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
                        <h3 class="text-themecolor m-b-0 m-t-0">Category</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Category</li>
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
                                        <h4 class="card-title">Category</h4>
                                        <h6 class="card-subtitle">There are a total of  <code>{{$totalCategories}}</code> categories.</h6>
                                    </div>
                                    <div class="col-8 text-end">
                                        <div class="w-80">
                                            <span id="url_search" data-url="{{ route('admin.category.search') }}"> </span>
                                            <form id="search-form" class="search" method="GET">
                                                <input type="text" name="keyword" id="search-input" class="searchTerm" placeholder="What are you looking for?">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                            <button id="add-new" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#categoryModal">Add New</button>
                                    </div>
                                </div>

                                <div id="get-result-search">
                                    <div class="table-responsive">
                                        <table class="table">
                                            {{--                                        {{dd($data)}}--}}

                                            <colgroup>
                                                <col width="150">
                                                <col width="400">
                                                <col width="400">
                                                <col>
                                                <col width="300">
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Parent</th>
                                                <th>Products</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <span id="get_limit" data-url="{{ route('admin.category.limit') }}"> </span>
                                            <span id="store_category" data-url="{{ route('admin.category.store') }}"> </span>
                                            @php
                                                $shows = [ '5', '7', '9'];
                                                $limit = request()->input('limit', 5);
                                                $page = request()->input('page', 1);
                                            @endphp


                                            @foreach($data as $category)
                                                <tr>
                                                    <td>{{$category->id}}</td>
                                                    <td>{{$category->name}}</td>
                                                    <td> {{ $category->parent?->name }}</td>
                                                    <td>{{$category->products->count() ?? 0}}</td>
                                                    <td class="d-flex btn-action">
                                                        <a  class="me-3">
{{--                                                            <button type="submit" class="btn btn-secondary">Update</button>--}}
                                                            <span id="update_category" data-url="{{ route('admin.category.update', $category->id) }}"> </span>

                                                            <button
                                                                class="btn btn-secondary btn-edit"
                                                                data-id="{{ $category->id }}"
                                                                data-name="{{ $category->name }}"
                                                                data-parent="{{ $category->parent_id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#categoryModal"
                                                            >
                                                                Update
                                                            </button>

                                                        </a>



                                                        <form id='delete-form-{{ $category->id }}'
                                                              action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-delete"
                                                                    data-id="{{ $category->id }}">Delete
                                                            </button>
                                                        </form>
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

                        <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" id="categoryForm">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <div class="modal-content p-20">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitle">Thêm danh mục</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" id="category-id">

                                            <div class="mb-3">
                                                <label class="form-label">Tên danh mục</label>
                                                <input type="text" name="name" id="category-name" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Danh mục cha</label>
                                                <select name="parent_id" id="category-parent" class="form-select">
                                                    <option value="">-- Không có --</option>
                                                    @foreach($all as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Lưu</button>
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
