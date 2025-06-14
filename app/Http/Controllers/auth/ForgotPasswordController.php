<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgotPassword.index');
    }
    public function test()
    {
        return view('email.adminForgotPassword');
    }

    public function forgot_password(Request $request)
    {
        $infoAdmin = Session::get('info_admin');

        if ($infoAdmin) {
            $otpCreatedAt = \Carbon\Carbon::parse($infoAdmin['otp_created_at']);
            if (\Carbon\Carbon::now()->diffInMinutes($otpCreatedAt) > 30) {
                Session::forget('info_admin');
                $infoAdmin = null;
            }
        }


        $email = $request->input("email");
        $admin = Customer::where('email', $email)->first();
        if (!$admin) {
            Session::put('alert_email_not_exist', [
                'alert__text' => '',
            ]);
            return back()->withErrors([
            ])->onlyInput('username');
        }



        $otp = mt_rand(100000, 999999);

        $data = [
            'otp' => $otp,
        ];
        $user['to'] = $email;
        Mail::send('.email.adminForgotPassword', $data, function ($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Activate account');
        });
        Session::put('info_admin', [
            'username' => $admin->username,
            'email' => $admin->email,
            'otp' => $otp,
            'otp_created_at' => now(),
        ]);
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];

        $firstChars = substr($name, 0, 3);
        $maskLength = strlen($name) - 3;
        $maskedChars = str_repeat('*', $maskLength > 0 ? $maskLength : 0);
        $email = $firstChars . $maskedChars . '@' . $domain;
        Session::put('alert_sendMail', [
            'alert_sendMail_type' => "success",
            'alert_sendMail_title' => "We have sent an email containing a password reset OTP to $email. Please check your email to continue.",
        ]);
        return redirect()->route('change-password');
    }
    public function update_password(Request $request)
    {
        $infoAdmin = Session::get('info_admin');
        if (!$infoAdmin) {
            Session::put('alert_change_password', [
                'alert_type' => 'error',
                'alert_title' => 'Update fail',
                'alert_text' => 'OTP does not exist or has expired.',
                'alert_reload' => 'true',
            ]);
            return redirect()->back();
        }
        $inputOtp = $request->input('otp');
        $otpCreatedAt = \Carbon\Carbon::parse($infoAdmin['otp_created_at']);
        if (\Carbon\Carbon::now()->diffInMinutes($otpCreatedAt) > 30) {
            Session::forget('info_admin');
            Session::put('alert_change_password', [
                'alert_type' => 'error',
                'alert_title' => 'Update fail',
                'alert_text' => 'OTP has expired, please request again.',
                'alert_reload' => 'true',
            ]);
            return redirect()->back();
        }
        if ($inputOtp != $infoAdmin['otp']) {
            Session::put('alert_change_password', [
                'alert_type' => 'error',
                'alert_title' => 'Update fail',
                'alert_text' => 'OTP is incorrect.',
                'alert_reload' => 'true',
            ]);
            return redirect()->back();
        }
        if ($request->password !== $request->password_confirmation) {
            Session::put('alert_change_password', [
                'alert_type' => 'error',
                'alert_title' => 'Update fail',
                'alert_text' => 'Confirmation password does not match.',
                'alert_reload' => 'false',
            ]);
            return redirect()->route('change-password');
        }
        $admin = Customer::where('email', $infoAdmin['email'])->first();
        if (!$admin) {
            Session::put('alert_change_password', [
                'alert_type' => 'error',
                'alert_title' => 'Update fail',
                'alert_text' => 'Customer does not exist.',
                'alert_reload' => 'true',
            ]);
            return redirect()->back();
        }

        $admin->password = Hash::make($request->password);
        $admin->save();
        Session::put('alert_change_password', [
            'alert_type' => 'success',
            'alert_title' => 'Update success',
            'alert_text' => 'Password update successful',
            'alert_reload' => 'false',
        ]);
        return redirect()->route('admin.login.index');
    }
    public function change_password(Request $request)
    {
        return view('auth.adminChangePassword.index');
    }
    public function change_password_sendMail(Request $request)
    {
        $user = Auth::user();
        return view('backend.changePassword.getOTP', compact('user'));
    }
    public function send_mail_process(Request $request)
    {

        $user = Auth::user();

        $email = $request->input("email");
        $admin = Customer::where('email', $email)->first();

        $otp = mt_rand(100000, 999999);

        $data = [
            'otp' => $otp,
        ];
        $user['to'] = $admin->email;
        Mail::send('.email.adminForgotPassword', $data, function ($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('Activate account');
        });
        Session::put('info_admin', [
            'username' => $admin->username,
            'email' => $admin->email,
            'otp' => $otp,
            'otp_created_at' => now(),
        ]);
        Session::put('alert_sendMail', [
            'alert_sendMail_type' => "success",
            'alert_sendMail_title' => "We have sent an email containing a password reset OTP to $email. Please check your email to continue.",
        ]);
        return redirect()->route("admin.password.index");
    }
    public function change_password_home(Request $request){
        return view('backend.changePassword.index');
    }

}
