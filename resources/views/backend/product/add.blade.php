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
                    <div class="col-lg-9 m-auto">
                        <div class="card">
                            <div class="card-block p-20">
                                <h4 class="card-title p-b-30 text-center">Add Product</h4>
                                <form method="post" action="
                                        @if($product)
                                            {{ route('admin.product.update', $product->id) }}
                                        @else
                                            {{ route('admin.product.store') }}
                                        @endif
                                    " enctype="multipart/form-data">

                                    @csrf
                                    @if($product != '')
                                        @method('PUT')
                                    @endif
                                    <div class="table-responsive px-5">
                                        <div class="row">
                                            <div class="col-4">
                                                <h5>Avatar</h5>
                                                <div class="controlContainer position-absolute">
                                                    <i class="bi bi-plus-circle-dotted text-center" id="icon_add"><br>
                                                        Add Image
                                                    </i>
                                                    <div class="inputFileHolder h-100">
                                                        <a class="w-100 h-100" href="#" title="Browse">
                                                        </a>
                                                        <input id="fileInput2" name="image" class="file-img fileInput w-100 h-100" title="Choose file to upload" value=""   type="file">
                                                        <input name="avatar_old"
                                                               value="{{ isset($product_image->image_url) ? $product_image->image_url : '' }}"
                                                               type="hidden">
                                                    </div>
                                                </div>
                                                <img id="image_product" class="border image-preview btn-select-img cursor-pointer" src="{{  isset($product_image->image_url) ? $product_image->image_url : '' }}">                                                     >
                                                <h6>(reasonable size: 350px x 400px)</h6>
                                            </div>
                                            <div class="col-8">
                                                <div class="w-100 mb-4">
                                                    <h5>Name</h5>
                                                    <input type="text" name="name" class="w-100 form-control" value="{{ $product != '' ? $product->name : '' }}">
                                                </div>
                                                <div class="w-100 mb-4 d-flex justify-content-between">
                                                    <div class="w-45">
                                                        <h5>Brand</h5>
                                                        <select  class="w-100 form-control" name="brand">
                                                            @foreach($brands as $brand)
                                                                <option

                                                                    @if($product != '')
                                                                        {{$product->brand_id  == $brand->id ? 'selected' : ''}}
                                                                    @endif

                                                                    value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="w-45">
                                                        <label><h5>Price ($)</h5></label>
                                                        <input type="number" name="price" class="w-100 form-control" value="{{ $product != '' ? $product->price : '' }}">
                                                    </div>
                                                </div>
                                                <div class="w-100 mb-4 d-flex justify-content-between">
                                                    <div class="w-45">
                                                        <h5>Category</h5>
                                                        <select  class="w-100 form-control" name="category">
                                                            @foreach($categories as $category)
                                                                <option
                                                                    @if($product != '')
                                                                        {{$product->category_id  == $category->id ? 'selected' : ''}}
                                                                    @endif
                                                                    value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="w-45">
                                                        <label><h5>Quantity</h5></label>
                                                        <input type="number" name="quantity" class="w-100 form-control"value="{{ $product != '' ? $product->quantity : '' }}">
                                                    </div>
                                                </div>
                                                <div class="w-100">
                                                    <h5>Description</h5>
                                                    <textarea class="w-100 form-control summernote" name="desc" style="height: 240px">{{ $product != '' ? $product->description : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-end mt-4 px-5">
                                        <div class="form position-relative margin-bottom-90 w-5 me-5">
                                            <button type="button" class="p-3 bg-danger border-0 rounded">
                                                <a class="text-white " href="{{route('admin.product')}}">Cancel</a></button>
                                        </div>
                                        <div class="form position-relative margin-bottom-90 w-10 ">
                                            <input type="submit" class="rounded bg-success text-white border-0 p-3" value="Save Changes">
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
