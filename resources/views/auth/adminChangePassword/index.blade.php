<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <link rel="stylesheet" href="{{ asset("backend/css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset("backend/css/uf-style.css") }}">
    <title>Login Form Bootstrap 1 by UIFresh</title>
</head>
<body>
<div class="uf-form-signin" style="    margin-top: 10rem !important;">
    <div class="text-center">
        <a><img src="{{asset('backend/images/logo.jpg')}}" alt="" width="100" height="100"></a>
        <h1 class="text-white h3">Forgot Password</h1>
    </div>
    <form class="mt-4" method="POST" action="{{route('update-password')}}" id="resetPasswordForm">
        @csrf
        @if(Session::has('info_admin'))
            @php
                $info = Illuminate\Support\Facades\Session::get('info_admin');
            @endphp
            <div class="input-group uf-input-group input-group-lg mb-3">
                <span class="input-group-text fa fa-user"></span>
                <input type="text" name="username" class="form-control" placeholder="{{ $info['username'] }}" readonly value="{{ $info['username'] }}">
            </div>
            <div class="input-group uf-input-group input-group-lg mb-3">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="{{ $info['email'] }}" readonly value="{{ $info['email'] }}">
            </div>
        @endif

        <div class="input-group uf-input-group input-group-lg mb-3">
            <span class="input-group-text fa fa-lock"></span>
            <input type="password" name="password" id="password" class="form-control new_password" placeholder="Enter your new password">
        </div>
        <div class="input-group uf-input-group input-group-lg mb-3">
            <span class="input-group-text fa fa-lock"></span>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control confirm_password" placeholder="Confirm password">
        </div>
        <p class="text-center text-danger notification d-none">Confirmation password does not match.</p>
        <div class="input-group uf-input-group input-group-lg mb-3">
            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
            <input type="number" name="otp" id="otp" class="form-control" placeholder="OTP" inputmode="numeric" pattern="[0-9]*" maxlength="6">
        </div>
        <div class="d-grid mb-4">
            <button type="submit" class="btn uf-btn-primary btn-lg btn-submit-update">Send</button>
        </div>
    </form>
</div>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js'></script>
<script src='{{asset("backend/js/func.js")}}'></script>
@if (isset(session('alert_sendMail')['alert_sendMail_type']))
    <script>
        alert_send_mail('{{session('alert_sendMail')['alert_sendMail_type']}}', '{{session('alert_sendMail')['alert_sendMail_title']}}')
        @php
            $userData = Illuminate\Support\Facades\Session::get('alert_sendMail', []);
            unset($userData['alert_sendMail_type']);
            unset($userData['alert_sendMail_title']);
            Illuminate\Support\Facades\Session::put('alert_sendMail', $userData);
        @endphp
    </script>
@endif
@if (isset(session('alert_change_password')['alert_type']))
    <script>
        alert_after_load('{{session('alert_change_password')['alert_title']}}', '{{session('alert_change_password')['alert_type']}}', '{{session('alert_change_password')['alert_text']}}', '{{session('alert_change_password')['alert_reload']}}')
        @php
            $userData = Illuminate\Support\Facades\Session::get('alert_sendMail', []);
            unset($userData['alert_title']);
            unset($userData['alert_type']);
            unset($userData['alert_text']);
            unset($userData['alert_reload']);
            Illuminate\Support\Facades\Session::put('alert_change_password', $userData);
        @endphp
    </script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-**************" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@include("backend.component.script")
</body>
</html>
