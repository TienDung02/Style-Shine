<!DOCTYPE html>
<html lang="en">



@include('backend.component.head')
<body class="fix-header fix-sidebar card-no-border">
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="main-wrapper">
    @include('backend.component.header')
    @include('backend.component.left-sidebar')
@yield('content')
@include('backend.component.script')


@if (isset(session('alert_')['alert_type']))
    <script>
        alert_after_load('{{session('alert_')['alert_title']}}', '{{session('alert_')['alert_type']}}', '{{session('alert_')['alert_text']}}', '{{session('alert_')['alert_reload']}}')
        @php
            $userData = Illuminate\Support\Facades\Session::get('alert_', []);
            unset($userData['alert_title']);
            unset($userData['alert_type']);
            unset($userData['alert_text']);
            Illuminate\Support\Facades\Session::put('alert_', $userData);
        @endphp
    </script>
@endif
@if (isset(session('alert_2')['alert_type']))
    <script>
        alert_after_load_2('{{session('alert_2')['alert_title']}}', '{{session('alert_2')['alert_type']}}', '{{session('alert_2')['alert_reload']}}')
        @php
            $userData = Illuminate\Support\Facades\Session::get('alert_2', []);
            unset($userData['alert_title']);
            unset($userData['alert_type']);
            Illuminate\Support\Facades\Session::put('alert_2', $userData);
        @endphp
    </script>
@endif
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
