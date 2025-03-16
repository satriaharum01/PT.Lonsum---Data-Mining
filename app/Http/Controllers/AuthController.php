<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Call Models
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        $this->data['title'] = 'Login';

        return view('front/login', $this->data);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Mengambil data user
            $rows = User::find(Auth::user()->id);
            $level = strtolower($rows->level);
            $rows->update([
                'last_login' => now()
             ]);
            return redirect()->intended('/admin/dashboard')
                        ->withSuccess('Signed in');
        }

        return redirect(route('account.login'))->withErrors(['alertMessage' => 'Email atau Password Salah','alertType' => 'alert-danger']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function getUser()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'id' => $user->id,
                'username' => $user->name, // atau sesuaikan field `username`
                'email' => $user->email
            ]);
        }

        return response()->json(['message' => 'Not authenticated'], 401);
    }
}
