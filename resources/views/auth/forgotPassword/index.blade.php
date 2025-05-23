<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset("backend/css/bootstrap.min.css") }}">
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset("backend/css/uf-style.css") }}">
    <title>Login Form Bootstrap 1 by UIFresh</title>
</head>
<body>
{{--    <div>--}}
<div class="uf-form-signin">
    <div class="text-center">
        <a><img src="{{asset('backend/images/logo.jpg')}}" alt="" width="100" height="100"></a>
        <h1 class="text-white h3">Forgot Password</h1>
    </div>
    <form class="mt-4" method="POST" action="{{route('send-mail')}}">
        @csrf
        <div class="input-group uf-input-group input-group-lg mb-3">
            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Enter your email">
        </div>
        @if (isset(session('alert_email_not_exist')['alert__text']))
            <p class="text-center text-danger">Email does not exist in the system</p>
            @php
                $userData = Illuminate\Support\Facades\Session::get('alert_email_not_exist', []);
                unset($userData['alert__text']);
                Illuminate\Support\Facades\Session::put('alert_email_not_exist', $userData);
            @endphp
        @endif

        <div class="d-grid mb-4">
            <button type="submit" class="btn uf-btn-primary btn-lg">Send</button>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-**************" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</html>
