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
                                <form method="post" action="{{route('admin.password.sendMail')}}">
                                    @csrf
                                    <div class="table-responsive px-5">
                                        <div class="row">
                                            <div class="col-10 m-auto">
                                                <div class="w-100 mb-4">
                                                    <h5 class="mb-4">Send email verification code</h5>
                                                    <p class="mb-4">Send the 6-digit verification code sent to you.</p>
                                                    <input class="form-control" type="text" name="email" readonly value="{{$user->email}}">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class=" mt-4  row">
                                        <div class="col-10 d-flex justify-content-center m-auto">
                                                    <input type="submit" class="rounded bg-success text-white border-0 p-3" value="Send">
                                        </div>
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
