<?php
namespace App\Http\Controllers;

use App\Models\GambarKendaraan;
use App\Models\Kendaraan;
use App\Models\KendaraanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::with('detail', 'images')->latest();

        // 🔥 HANYA FILTER AVAILABLE UNTUK API (USER / FLUTTER)
        if ($request->expectsJson()) {
            $query->where('status', 'available');
        }

        // FILTER STATUS (opsional dari request)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%$search%")
                    ->orWhere('model', 'like', "%$search%")
                    ->orWhere('plate_number', 'like', "%$search%");
            });
        }

        $kendaraan = $query->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data'    => $kendaraan,
            ]);
        }

        // ADMIN → VIEW (SEMUA DATA)
        return view('kendaraan.index', compact('kendaraan'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'            => 'required',
            'brand'           => 'required',
            'model'           => 'required',
            'year'            => 'required|numeric|min:1900|max:' . (date('Y') + 1),
            'plate_number'    => 'required|unique:kendaraans',
            'price_per_day'   => 'required|numeric|min:0',
            'engine_capacity' => 'nullable|numeric',
            'fuel_type'       => 'nullable',
            'transmission'    => 'nullable',
            'seat_count'      => 'nullable|numeric|min:1',
            'images.*'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $kendaraan = Kendaraan::create([
                'type'          => $request->type,
                'brand'         => $request->brand,
                'model'         => $request->model,
                'year'          => $request->year,
                'plate_number'  => $request->plate_number,
                'price_per_day' => $request->price_per_day,
                'color'         => $request->color,
                'status'        => $request->status ?? 'available',
            ]);

            KendaraanDetail::create([
                'kendaraan_id'    => $kendaraan->id,
                'engine_capacity' => $request->engine_capacity,
                'fuel_type'       => $request->fuel_type,
                'transmission'    => $request->transmission,
                'seat_count'      => $request->seat_count,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('kendaraan', 'public');

                    GambarKendaraan::create([
                        'kendaraan_id' => $kendaraan->id,
                        'image_path'   => $path,
                        'is_primary'   => $index === 0,
                    ]);
                }
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kendaraan berhasil ditambahkan',
                    'data'    => $kendaraan->load('detail', 'images', 'reviews.user'),
                ], 201);
            }

            return redirect()->route('admin.kendaraan.index')
                ->with('success', 'Kendaraan berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan kendaraan',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Request $request, Kendaraan $kendaraan)
    {
        $kendaraan->load('detail', 'images', 'reviews');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Detail kendaraan',
                'data'    => $kendaraan,
            ], 200);
        }

        return view('kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        $kendaraan->load('detail', 'images');
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'type'          => 'required',
            'brand'         => 'required',
            'model'         => 'required',
            'year'          => 'required|numeric',
            'plate_number'  => 'required|unique:kendaraans,plate_number,' . $kendaraan->id,
            'price_per_day' => 'required|numeric',
            'color'         => 'required',
            'status'        => 'required',
        ]);

        DB::beginTransaction();
        try {
            $kendaraan->update($validated);

            $kendaraan->detail->update($request->only([
                'engine_capacity', 'fuel_type', 'transmission', 'seat_count',
            ]));

            DB::commit();

            // CEK DULU: Request dari API atau Web?
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kendaraan berhasil diperbarui',
                    'data'    => $kendaraan->load('detail', 'images'),
                ], 200);
            }

            // Jika dari Web, redirect ke index
            return redirect()->route('admin.kendaraan.index')
                ->with('success', 'Kendaraan berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal update kendaraan',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            // Jika dari Web, kembali dengan error
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Kendaraan $kendaraan)
    {
        DB::beginTransaction();
        try {
            // hapus gambar dari storage
            foreach ($kendaraan->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // hapus kendaraan
            $kendaraan->delete();

            DB::commit();

            // CEK DULU: Request dari API atau Web?
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kendaraan berhasil dihapus',
                ], 200);
            }

            // Jika dari Web, redirect ke index
            return redirect()->route('admin.kendaraan.index')
                ->with('success', 'Kendaraan berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus kendaraan',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            // Jika dari Web, kembali dengan error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
