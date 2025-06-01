@extends('backend.layouts.layout')
@section('content')
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Product</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="">Home</a></li>
                            <li class="breadcrumb-item active"><a href="">Product</a></li>
                            <li class="breadcrumb-item">View</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <h4 class="card-title p-b-30 text-center">Reviews</h4>
                    <div class="col-lg-8 m-auto">
                        <div>
                            <div class="review-container">
                                <h2>Overall rating</h2>
                                <div class="rating-summary row d-flex">
                                    <div class="rating-score col-lg-2">
                                        <span id="score" class="score">2</span>
                                        <div class="wraper d-flex justify-content-center">
                                            <div class="stars">
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="tooltip rating" data-rating="0.0"></div>
                                            </div>
                                            <div class="shadows">
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="star"></div>
                                                <div class="star"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating-bars col-lg-4">
                                        <div class="rating-row">
                                            <span>5 ★</span>
                                            <div class="progress-bar"><div class="progress" style="width: 60%;"></div></div>
                                            <span>60%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span>4 ★</span>
                                            <div class="progress-bar"><div class="progress" style="width: 25%;"></div></div>
                                            <span>25%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span>3 ★</span>
                                            <div class="progress-bar"><div class="progress" style="width: 10%;"></div></div>
                                            <span>10%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span>2 ★</span>
                                            <div class="progress-bar"><div class="progress" style="width: 3%;"></div></div>
                                            <span>3%</span>
                                        </div>
                                        <div class="rating-row">
                                            <span>1 ★</span>
                                            <div class="progress-bar"><div class="progress" style="width: 2%;"></div></div>
                                            <span>2%</span>
                                        </div>
                                    </div>
                                    <div class="recommend col-lg-5">
                                        <!-- Percentages -->
                                        <div class="circle-rating">{{$percentageReviewed}}</div>
                                        <p>Recommend working here to a friend</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="review-container">
                            <div class="review  ">
                                <div class="user-info row">
                                    <div class="avatar-review col-lg-1">
                                        <img src="{{asset('/frontend/images/anime-girl-cyberpunk-sci-fi-cherry-blossom-ai-4k-wallpaper-uhdpaper.com-729@1@l.jpg')}}" alt="">
                                    </div>
                                    <div class="col-lg-11 text-start">
                                        <strong>nhinhinhyyy</strong> ★★★★★
                                        <span class="date ">2024-12-08 23:38 | Phân loại hàng: ĐEN và GHI, M (40-55kg)</span>
                                        <p class="comment text-start fw-normal me-5 mt-3">
                                            Tôi đã nhận được hàng rồi nhé
                                            Giao hàng nhanh chóng
                                            Đóng gói cẩn thận
                                            Quần đẹp, đã sử dụng cảm thấy khá là OK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review  ">
                                <div class="user-info row">
                                    <div class="avatar-review col-lg-1">
                                        <img src="{{asset('/frontend/images/anime-girl-cyberpunk-sci-fi-cherry-blossom-ai-4k-wallpaper-uhdpaper.com-729@1@l.jpg')}}" alt="">
                                    </div>
                                    <div class="col-lg-11 text-start">
                                        <strong>nhinhinhyyy</strong> ★★★★★
                                        <span class="date ">2024-12-08 23:38 | Phân loại hàng: ĐEN và GHI, M (40-55kg)</span>
                                        <p class="comment text-start fw-normal me-5 mt-3">
                                            Tôi đã nhận được hàng rồi nhé
                                            Giao hàng nhanh chóng
                                            Đóng gói cẩn thận
                                            Quần đẹp, đã sử dụng cảm thấy khá là OK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review  ">
                                <div class="user-info row">
                                    <div class="avatar-review col-lg-1">
                                        <img src="{{asset('/frontend/images/anime-girl-cyberpunk-sci-fi-cherry-blossom-ai-4k-wallpaper-uhdpaper.com-729@1@l.jpg')}}" alt="">
                                    </div>
                                    <div class="col-lg-11 text-start">
                                        <strong>nhinhinhyyy</strong> ★★★★★
                                        <span class="date ">2024-12-08 23:38 | Phân loại hàng: ĐEN và GHI, M (40-55kg)</span>
                                        <p class="comment text-start fw-normal me-5 mt-3">
                                            Tôi đã nhận được hàng rồi nhé
                                            Giao hàng nhanh chóng
                                            Đóng gói cẩn thận
                                            Quần đẹp, đã sử dụng cảm thấy khá là OK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review  ">
                                <div class="user-info row">
                                    <div class="avatar-review col-lg-1">
                                        <img src="{{asset('/frontend/images/anime-girl-cyberpunk-sci-fi-cherry-blossom-ai-4k-wallpaper-uhdpaper.com-729@1@l.jpg')}}" alt="">
                                    </div>
                                    <div class="col-lg-11 text-start">
                                        <strong>nhinhinhyyy</strong> ★★★★★
                                        <span class="date ">2024-12-08 23:38 | Phân loại hàng: ĐEN và GHI, M (40-55kg)</span>
                                        <p class="comment text-start fw-normal me-5 mt-3">
                                            Tôi đã nhận được hàng rồi nhé
                                            Giao hàng nhanh chóng
                                            Đóng gói cẩn thận
                                            Quần đẹp, đã sử dụng cảm thấy khá là OK</p>
                                    </div>
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
