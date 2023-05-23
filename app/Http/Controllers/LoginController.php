<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create() : View {
        return view('auth.login');
    }

    public function store(Request $request) : RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', Password::default()],
        ]);

        if(! Auth::attempt($credentials, $request->input('remember'))){
            return back()->withErrors(['email' => 'Mật khẩu hoặc tài khoản không chính xác']);
        }

        return redirect()->route('home');
    }
}
