<?php
namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect('/home')->with('success', 'Welcome back, Admin!');
            }

            return redirect('/welcome')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'customer',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/welcome')->with('success', 'Registration successful!');
    }

    public function apiCustomerDashboard(Request $request)
    {
        $user = $request->user();

        // Optional: pastikan hanya customer
        if ($user->role !== 'customer') {
            return response()->json([
                'message' => 'Akses ditolak',
            ], 403);
        }

        $vehicles = Kendaraan::latest()->take(5)->get();

        return response()->json([
            'message'  => 'Dashboard customer',
            'user'     => $user,
            'vehicles' => $vehicles,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user = Auth::user();

        // hapus token lama (optional)
        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // ✅ REGISTER API
    public function apiRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'customer',
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    // ✅ LOGOUT API
    public function apiLogout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}
