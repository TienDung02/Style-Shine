@extends('backend.layouts.layout')
@section('content')

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard.index')}}">Home</a></li>
                            <li class="breadcrumb-item "><a href="{{route('admin.user')}}">User</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-block">
                                <center class="m-t-30 p-b-20"> <img src="{{$user->avatar_url}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$user->username}}</h4>
                                    <h6 class="card-subtitle">{{$user->email}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-8"><a href="javascript:void(0)" class="link"><font class="font-medium">Number of products purchased: {{$user->total_quantity}}</font></a></div>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-block">
                                <form class="form-horizontal form-material p-40">
                                    <div class="form-group">
                                        <label class="col-md-12">Full Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line" value="{{$user->cus_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="example-email" value="{{$user->email}}" id="example-email" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="123 456 7890" value="{{$user->phone_number}}" class="form-control form-control-line" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Message</label>
                                        <div class="col-md-12">
                                            <input rows="5" class="form-control form-control-line" readonly value="{{$user->address}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-success">
                                            <a href="{{route('admin.user')}}" class="text-white fw-bold">
                                                Go Back
                                            </a>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                © 2017 Material Pro Admin by wrappixel.com
            </footer>
        </div>
    </div>
@endsection
