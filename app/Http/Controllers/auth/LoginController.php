<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login.index');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::guard('admin')->attempt($credentials)) {
            Session::put('alert_', [
                'alert__type' => 'success',
                'alert__title' => 'login success',
                'alert__text' => '',
                'alert_reload' => 'success',
            ]);
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }
        Session::put('alert_login_fail', [
            'alert__text' => 'Username or password incorrect',
        ]);
        return back()->withErrors([
        ])->onlyInput('username');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

}
