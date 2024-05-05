<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function index() {
        $user = Auth::user();
        $activeMenu = 'Login';
        $breadcrumb = (object) [
            'title' => 'Login',
            'list'  => ['Login']
        ];

        if ($user) {
            if ($user->level_id == 1) {
                return redirect()->intended('admin');
            } else if ($user->level_id == 2) {
                return redirect()->intended('manager');
            }
        }

        return view('login', ['activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb]);
    }

    public function proses_login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credential = $request->only('username', 'password');

        if (Auth::attempt($credential)) {
            $user = Auth::user();

            if ($user->level_id == 1) {
                return redirect()->intended('admin');
            } else if ($user->level_id == 2) {
                return redirect()->intended('manager');
            }

            return redirect()->intended('/');
        }

        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
    }

    public function register() {
        $activeMenu = 'Register';
        $breadcrumb = (object) [
            'title' => 'Register',
            'list'  => ['Register']
        ];


        return view('register', ['activeMenu' => $activeMenu, 'breadcrumb' => $breadcrumb]);
    }

    public function logout(Request $request) {
        $request->session()->flush();

        Auth::logout();

        return redirect('login');
    }
}