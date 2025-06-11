@extends('backend.layouts.layout')
@section('content')



        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Product</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card p-20" id="get-result-limit">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-3">
                                        <h4 class="card-title">Product</h4>
                                        <h6 class="card-subtitle">There are a total of  <code>{{$totalProducts}}</code> products.</h6>
                                    </div>
                                    <div class="col-7 text-end">
                                        <div class="w-80">
                                            <span id="url_search" data-url="{{ route('admin.product.search') }}"> </span>
                                            <form id="search-form" class="search" method="GET">
                                                <input type="text" name="keyword" id="search-input" class="searchTerm" placeholder="What are you looking for?">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('admin.product.export.csv') }}" class="btn btn-success mb-3">Export CSV</a>
                                    </div>
                                    <div class="col-1">
                                        <a id="add-new" href="{{route('admin.product.add')}}" class="btn waves-effect waves-light btn-warning hidden-md-down">Add New</a>
                                    </div>
                                </div>

                                <div id="get-result-search">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <colgroup>
                                                <col width="100">
                                                <col width="300">
                                                <col width="220">
                                                <col width="210">
                                                <col width="210">
                                                <col width="220">
                                                <col >
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Price (VND)</th>
                                                <th>Quantity</th>
                                                <th>Quantity Sold</th>
                                                <th>Rating</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <span id="get_limit" data-url="{{ route('admin.product.limit') }}"> </span>
                                            @php
                                                $shows = [ '5', '7', '9'];
                                                $limit = request()->input('limit', 5);
                                                $page = request()->input('page', 1);
                                            @endphp
                                            @foreach($data as $product)
                                                <tr>
                                                    <td>{{$product->ID_PRODUCT}}</td>
                                                    <td>{{$product->NAME_PRODUCT}}</td>
                                                    <td>{{$product->PRICE}}</td>
                                                    <td>{{$product->QUALITY}}</td>
                                                    <td>{{$product->sold_quantity}}</td>
                                                    <td>
                                                        @if($product->reviews_avg_rating == 5)
                                                            <i class="bi bi-star-fill"></i>
                                                        @elseif($product->reviews_avg_rating == 0 ||$product->reviews_avg_rating == null)
                                                            <i class="bi bi-star"></i>
                                                        @else
                                                            <i class="bi bi-star-half"></i>
                                                        @endif
                                                        {{ round($product->reviews_avg_rating, 1) }}({{$product->reviews_count}})
                                                    </td>
                                                    <td class="d-flex btn-action">
                                                        <a href="{{ route('admin.product.edit', $product->ID_PRODUCT) }}" class="me-3">
                                                            <button type="submit" class="btn btn-secondary">Update</button>
                                                        </a>
                                                        <form id='delete-form-{{ $product->ID_PRODUCT }}' class="me-3"
                                                              action="{{ route('admin.product.destroy', $product->ID_PRODUCT) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" style="height: 34px" class="btn btn-danger btn-delete"
                                                                    data-id="{{ $product->ID_PRODUCT }}">Delete
                                                            </button>
                                                        </form>

                                                        <a href="{{ route('admin.product.view', $product->ID_PRODUCT) }}" class="me-3">
                                                            <button type="submit" class="btn btn-info text-white">See Reviews</button>
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
            </div>
            <footer class="footer">
                © 2017 Material Pro Admin by wrappixel.com
            </footer>
        </div>
    </div>
@endsection
