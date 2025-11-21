<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegister()
    {
        // Authorization: hanya guest yang bisa akses form register
        $this->authorize('guest-only');
        
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Authorization: hanya guest yang bisa register
        $this->authorize('guest-only');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user)); // Trigger email verification (jika ada)

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        // Authorization: hanya guest yang bisa akses form login
        $this->authorize('guest-only');
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Authorization: hanya guest yang bisa login
        $this->authorize('guest-only');

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        // Authorization: hanya user yang login yang bisa logout
        $this->authorize('auth-only');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        // Authorization: hanya user yang login yang bisa lihat profile
        $this->authorize('auth-only');
        
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        // Authorization: hanya user yang login yang bisa update profile
        $this->authorize('auth-only');

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate!');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        // Authorization: hanya user yang login yang bisa ganti password
        $this->authorize('auth-only');
        
        return view('auth.change-password');
    }

    /**
     * Handle change password request
     */
    public function changePassword(Request $request)
    {
        // Authorization: hanya user yang login yang bisa ganti password
        $this->authorize('auth-only');

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                $validator->errors()->add('current_password', 'Password saat ini salah.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}