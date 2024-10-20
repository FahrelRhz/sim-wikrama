<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.admin.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }
    
        return back()->withErrors(['email' => 'Email or password is incorrect.']);
    }
    
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/admin/login');
    }

}
