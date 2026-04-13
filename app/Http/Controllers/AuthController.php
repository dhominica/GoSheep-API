<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // Check if the user is owner and active
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Only allow 'owner' role to login
            if ($user->role !== 'owner') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Anda tidak memiliki akses ke halaman ini. Hanya Owner yang diizinkan.',
                ])->onlyInput('email');
            }

            // Only allow 'active' status
            if ($user->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }

            // Authentication passed & user is active owner
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
