@extends('backend.layouts.layout')
@section('content')

        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include("backend.component.left-sidebar")
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Order</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
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
                        <div class="card p-20" id="get-result-limit">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-3">
                                        <h4 class="card-title">Order</h4>
                                        <h6 class="card-subtitle">There are a total of  <code>{{$total}}</code> orders.</h6>
                                    </div>
                                    <div class="col-8 text-end">
                                        <div class="w-80">
                                            <span id="url_search" data-url="{{ route('admin.order.search') }}"> </span>
                                            <form id="search-form" class="search" method="GET">
                                                <input type="text" name="keyword" id="search-input" class="searchTerm" placeholder="What are you looking for?">
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="get-result-search">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <colgroup>
                                                <col width="100">
                                                <col>
                                                <col>
                                                <col>
                                                <col width="220">
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Payment Method</th>
                                                <th>Price ($)</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <span id="get_limit" data-url="{{ route('admin.order.limit') }}"> </span>
                                            @php
                                                $shows = [ '5', '7', '9'];
                                                $limit = request()->input('limit', 5);
                                                $page = request()->input('page', 1);
                                            @endphp
                                            @foreach($data as $order)
                                                <tr>
                                                    <td>{{$order->id}}</td>
                                                    <td>{{$order->username}}</td>
                                                    <td>{{$order->payment_method}}</td>
                                                    <td>{{$order->total_price}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                                        <td class="d-flex btn-action">
                                                        <a href="{{ route('admin.order.view', $order->id) }}" class="me-3">
                                                            <button type="submit" class="btn btn-info text-white">View Detail</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-bottom">
                                        <div class="paginate" id="pagination-links">
                                            {{$data->withQueryString()->appends($_GET)->links('.backend.component.paginate')}}
                                        </div>

                                        <form action="" method="post">
                                            @csrf
                                            <div class="border-start">
                                                <p>Show</p>
                                                <select name="limit-category" id="show-limit">
                                                    @foreach($shows as $show)
                                                        <option {{$show==$limit?'selected':''}} value="{{$show}}">{{$show}}</option>
                                                    @endforeach
                                                </select>
                                                <p>item</p>
                                            </div>
                                        </form>
                                    </div>
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

