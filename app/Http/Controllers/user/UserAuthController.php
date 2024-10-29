<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Jurusan; 
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect('/user/dashboard'); 
        }

        return view('pages.user.login.index'); 
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'jurusan' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $user = User::where('name', $request->name)
            ->where('email', $request->email)
            ->whereHas('jurusan', function ($query) use ($request) {
                $query->where('nama_jurusan', $request->jurusan);
            })
            ->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended('/user/dashboard');
        }
    
        return back()->withErrors(['login' => 'Email, nama, jurusan, atau password tidak sesuai.']);
    }
    
    
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/user/login');
    }
}
