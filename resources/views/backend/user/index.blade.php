@extends('backend.layouts.layout')
@section('content')


        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Customer</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Customer</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card p-20">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-3">
                                        <h4 class="card-title">Customer</h4>
                                        <h6 class="card-subtitle">There are a total of  <code>{{$totalCustomers}}</code> customer.</h6>
                                    </div>
                                    <div class="col-8 text-end">
                                        <div class="w-80">
                                            <form class="search">
                                                <input type="text" class="searchTerm" placeholder="What are you looking for?">
                                                <button type="submit" class="searchButton">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <a href="https://themewagon.com/themes/bootstrap-4-responsive-admin-template/" class="btn waves-effect waves-light btn-warning hidden-md-down">Add New</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
{{--                                        {{dd($data)}}--}}
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Name</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
{{--                                        @foreach($data as $product)--}}
{{--                                            {{dd($product)}}--}}
{{--                                            <tr>--}}
{{--                                                <td>1</td>--}}
{{--                                                <td>{{$product->name_product}}</td>--}}
{{--                                                <td>Prohaska</td>--}}
{{--                                                <td>@Genelia</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}


{{--                                        <span id="change_active" data-url="{{ route('admin.candidate.update') }}"> </span>--}}
                                        @php
                                            $shows = [ '5', '10', '15'];
                                            $limit = request()->input('limit', 5);
                                            $page = request()->input('page', 1);
                                        @endphp
                                        @foreach($data as $key => $customer  )
                                            <tr>
                                                <td>{{ ($page-1)*$limit+$key+1}}</td>
                                                <td>{{$customer->username}}</td>
                                                <td>{{$customer->cus_name}}</td>
                                                <td>{{$customer->email}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
