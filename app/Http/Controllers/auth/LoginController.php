<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('auth.login.index', compact('user'));
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === 1) {
                return redirect()->route('admin.dashboard.index');
            } else {
                Session::put('alert_login_fail', [
                    'alert__text' => 'You are not authorized to access this site.',
                ]);
                return back()->withErrors([
                ])->onlyInput('username');
            }
        }
        Session::put('alert_login_fail', [
            'alert__text' => 'Username or password incorrect',
        ]);
        return back()->withErrors([
        ])->onlyInput('username');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.index');
    }
    public function forgot_password(Request $request)
    {
        $data = [
            'name' => 1,
            'password' => 123,
            'url' => 1
        ];
        $user['to'] = 2;
        Mail::send('.emails.myMailTemplate', $data, function ($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Activate account');
        });
        return redirect()->route('admin.login.index');
    }
    public function forgot_password_2(Request $request)
    {
        return view('email.adminForgotPassword');
    }
}
