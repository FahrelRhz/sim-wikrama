<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect('/user/dashboard'); 
        }

        return view('pages.user.login.index'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'email','jurusan', 'password');
    
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('/user/dashboard');
        }
    
        return back()->withErrors(['email' => 'Email or password is incorrect.']);
    }
    
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/user/login');
    }
}
