<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset("backend/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-…" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset("backend/css/all.min.css") }}">
    <link rel="stylesheet" href="{{ asset("backend/css/uf-style.css") }}">
    <title>Login Form Bootstrap 1 by UIFresh</title>
  </head>
  <body>
{{--    <div>--}}
        <div class="uf-form-signin">
            <div class="text-center">
                <a><img src="{{asset('backend/images/logo.jpg')}}" alt="" width="100" height="100"></a>
                <h1 class="text-white h3">Account Login </h1>
            </div>
            <form class="mt-4" method="POST" action="{{route('admin.login')}}">
                @csrf
                <div class="input-group uf-input-group input-group-lg mb-3">
                    <span class="input-group-text fa fa-user"></span>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="input-group uf-input-group input-group-lg mb-3">
                    <span class="input-group-text fa fa-lock"></span>
                    <input type="text" name="password" class="form-control" placeholder="Password">
                </div>
                @if (isset(session('alert_login_fail')['alert__text']))
                    <p class="text-center text-danger">Username or password incorrect</p>
                    @php
                        $userData = Illuminate\Support\Facades\Session::get('alert_login_fail', []);
                        unset($userData['alert__text']);
                        Illuminate\Support\Facades\Session::put('alert_login_fail', $userData);
                    @endphp
                @endif
                <div class="d-flex mb-3 justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input uf-form-check-input" id="exampleCheck1">
                        <label class="form-check-label text-white" for="exampleCheck1">Remember Me</label>
                    </div>
                    <a href="#">Forgot password?</a>
                </div>
                <div class="d-grid mb-4">
                    <button type="submit" class="btn uf-btn-primary btn-lg">Login</button>
                </div>
            </form>
{{--        </div>--}}
    </div>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js'></script>
    <script src='{{asset("backend/js/func.js")}}'></script>
    <!-- JavaScript -->
{{--    @if (isset(session('alert_login_fail')['alert__text']))--}}
{{--        <script>--}}
{{--            alert_login_fail('{{session('alert_login_fail')['alert__text']}}')--}}
{{--            @php--}}
{{--                $userData = Illuminate\Support\Facades\Session::get('alert_login_fail', []);--}}
{{--                unset($userData['alert__text']);--}}
{{--                Illuminate\Support\Facades\Session::put('alert_login_fail', $userData);--}}
{{--            @endphp--}}
{{--        </script>--}}
{{--    @endif--}}
    <!-- Separate Popper and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  </body>
</html>
