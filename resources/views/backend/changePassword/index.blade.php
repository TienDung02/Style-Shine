@extends('backend.layouts.layout')

@section('content')

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Product</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{route('admin.dashboard.index')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{route('admin.product')}}">Product</a></li>
                            <li class="breadcrumb-item">Add</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-4 m-auto">
                        <div class="card">
                            <div class="card-block p-20">
                                <h3 class="card-title p-b-30 text-center" style="font-family: 'Cambria Math'">
                                    <img style="height: 60px" src="{{asset('/backend/images/logo.png')}}"> &nbsp;&nbsp;&nbsp;
                                    Style & Shine
                                </h3>
                                <form class="mt-4" method="POST" action="{{route('update-password')}}" id="resetPasswordForm">
                                    @csrf
                                    @if(Session::has('info_admin'))
                                        @php
                                            $info = Illuminate\Support\Facades\Session::get('info_admin');
                                        @endphp
                                        <div class="input-group input-group-lg mb-3">
                                            <div class="uf-input-group">
                                                <span class="input-group-text fa fa-user"></span>
                                            </div>
                                            <input type="text" name="username" class="form-control" placeholder="{{ $info['username'] }}" readonly value="{{ $info['username'] }}">
                                        </div>
                                        <div class="input-group input-group-lg mb-3">
                                            <div class="uf-input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>

                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="{{ $info['email'] }}" readonly value="{{ $info['email'] }}">
                                        </div>
                                    @endif

                                    <div class="input-group  input-group-lg mb-3">
                                        <div class="uf-input-group">
                                            <span class="input-group-text fa fa-lock"></span>
                                        </div>
                                        <input type="password" name="password" id="password" class="form-control new_password" placeholder="Enter your new password">
                                    </div>
                                    <div class="input-group input-group-lg mb-3">
                                        <div class="uf-input-group">
                                            <span class="input-group-text fa fa-lock"></span>

                                        </div>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control confirm_password" placeholder="Confirm password">
                                    </div>
                                    <p class="text-center text-danger notification d-none">Confirmation password does not match.</p>
                                    <div class="input-group input-group-lg mb-3">
                                        <div class="uf-input-group">
                                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                        </div>
                                        <input type="number" name="otp" id="otp" class="form-control" placeholder="OTP" inputmode="numeric" pattern="[0-9]*" maxlength="6">
                                    </div>
                                    <div class="d-grid mt-5 mb-4 d-flex justify-content-center">
                                        <button type="submit" class="rounded p-2 fw-bolder border-0 bg-success text-white w-50">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2017 Material Pro Admin by wrappixel.com
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
@endsection
