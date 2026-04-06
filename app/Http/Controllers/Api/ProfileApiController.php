<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileApiController extends Controller
{
    /**
     * GET /api/profile
     * Ambil data user yang sedang login beserta jumlah booking
     */
    public function show(Request $request)
    {
        $user = $request->user()->loadCount('bookings');

        return response()->json([
            'success' => true,
            'data'    => $user,
        ]);
    }

    /**
     * POST /api/profile/update  (method spoofing _method=PUT)
     * Update nama, telepon, alamat, avatar
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path         = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name    = $request->name;
        $user->phone   = $request->phone;
        $user->address = $request->address;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user->loadCount('bookings'),
        ]);
    }

    /**
     * PUT /api/profile/password
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => [
                    'current_password' => ['Password saat ini tidak sesuai.'],
                ],
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah',
        ]);
    }
}
