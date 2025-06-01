@extends('backend.layouts.layout')
@section('content')
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Order</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="">Home</a></li>
                            <li class="breadcrumb-item active"><a href="">Order</a></li>
                            <li class="breadcrumb-item">View</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-6 m-auto">
                        <div class="review-container p-50">
                            <div class="review  ">
                               <h3>Order Receipt</h3>
                            </div>
                            <div class="m-t-20  ms-3">
                                <div class="d-flex row">
                                    <div class="col-6 d-flex"><h6>Customer Name: &nbsp;</h6>{{$order->user->full_name}}</div>
                                    <div class="col-6 d-flex"><h6>Seller: &nbsp; </h6>Style & Shine</div>
                                </div>
                                <div class="m-t-10 d-flex">
                                    <h6>Shipping Address: &nbsp;</h6>{{$order->user->address}}
                                </div>
                            </div>
                            <div class="m-t-20 d-flex px-3 row ">
                                    <div class="col-3"><h6>Order ID</h6>{{$order->id}}</div>
                                    <div class="col-3"><h6>Order Date</h6>{{$order->created_at}}</div>
                                    <div class="col-3"><h6>Payment Date</h6>{{$order->payment_date}}</div>
                                    <div class="col-3"><h6>Payment Method</h6>{{$order->payment_method}}</div>
                            </div>
                            <div class="m-t-20  ">
                                <h4>Order Details</h4>
                                <table class="table">
                                    <colgroup>
                                        <col width="100">
                                        <col >
                                        <col width="180">
                                        <col width="100">
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Product Name</th>
                                        <th>Price ($)</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach($data as $detail)
                                        <tr>
                                            <td><a href="{{ route('admin.product.edit', $detail->product->id) }}" style="display: block; color: inherit; text-decoration: none;">{{$count}}</td>
                                            <td><a href="{{ route('admin.product.edit', $detail->product->id) }}" style="display: block; color: inherit; text-decoration: none;">{{$detail->product->name}}</td>
                                            <td><a href="{{ route('admin.product.edit', $detail->product->id) }}" style="display: block; color: inherit; text-decoration: none;">{{$detail->product->price}}</td>
                                            <td><a href="{{ route('admin.product.edit', $detail->product->id) }}" style="display: block; color: inherit; text-decoration: none;">{{$detail->quantity}}</td>
                                            @php
                                                $count++;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-t-30 d-flex justify-content-end ">
                                <div class="me-3">
                                    <div><h6>Subtotal {{$totalQuantity = $data->sum('quantity')}} item(s): </h6> </div>
                                    <div><h6>Shipping: </h6> </div>
                                    <div><h6>Total Payment: </h6></div>
                                </div>
                                <div>
                                    <div><h6>{{$order->total_price}}$</h6> </div>
                                    <div><h6>2$</h6> </div>
                                    <div><h6>{{$order->total_price + 2}}</h6></div>
                                </div>
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
