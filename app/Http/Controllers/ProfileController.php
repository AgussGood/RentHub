<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function show()
    {
        return view('profile'); // resources/views/profile.blade.php
    }

    /**
     * Update name, phone, address, and avatar.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
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

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Verify current password
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah!');
    }
}
