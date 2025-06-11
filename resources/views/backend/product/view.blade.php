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
                        <div class="table-responsive px-5">
                            <div class="row">
{{--                                {{dd($product)}}--}}
                                <div class="col-4">
                                    <img id="image_product" class="border image-preview btn-select-img cursor-pointer" src="{{$product->IMAGE_URL}}">
                                </div>
                                <div class="col-8">
                                    <div class="w-100 mb-4">
                                        <h5>Name</h5>
                                        <p>{{$product->NAME_PRODUCT}}</p>
                                    </div>
                                    <div class="w-100 mb-4 d-flex justify-content-between">
                                        <div class="w-45">
                                            <h5>Brand</h5>
                                            <p>{{$product->BRAND}}</p>
                                        </div>
                                        <div class="w-45">
                                            <label><h5>Price ($)</h5></label>
                                            <p>{{$product->PRICE}} (VND)</p>
                                        </div>
                                    </div>
                                    <div class="w-100 mb-4 d-flex justify-content-between">
                                        <div class="w-45">

                                            <h5>Category</h5>
                                            <p>{{$product->category_name}} </p>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <h5>Description</h5>
                                        <p>{{$product->DESCRIPTION}} </p>
                                    </div>
                                </div>
                            </div>
                        <div>
                            <div class="review-container">
                                <h2>Overall rating ({{$quantitySold}} products sold) </h2>
                                <div class="rating-summary row d-flex">
                                    <div class="rating-score col-lg-2">
                                        <div id="score" class="score">
                                            <p>{{ round($averageRating, 1)}}</p>
                                            <div> ({{$countRating}})</div>
                                        </div>
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
                                        @foreach($ratings as $rating)
                                            <div class="rating-row">
                                                <span>{{$rating->RATING}} ★</span>
                                                <div class="progress-bar"><div class="progress" style="width: {{($rating->total/$countRating)*100}}%;"></div></div>
                                                <span class="rating-percent">{{round(($rating->total/$countRating)*100, 2)}} %</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="recommend col-lg-5">
                                        <!-- Percentages -->
                                        <div class="circle-rating">{{$percentageReviewed}}%</div>
                                        <p class="ms-4 fs-5 mb-0">of customers left a review after purchasing.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="review-container">
                            @foreach($reviews as $review)
                            <div class="review">
                                <div class="user-info row">
                                    <div class="avatar-review col-lg-1">
                                        <img src="{{ $review->AVATAR_URL }}" alt="">
                                    </div>
                                    <div class="col-lg-11 text-start">
                                        <div>
                                            <strong>{{ $review->CUS_NAME }}</strong>
                                            <div class="many-rating-wrapper">
                                                <span class="many-rating many-rating--sm" data-rating-value="{{$review->RATING}}"></span>
                                            </div>
                                            <p class="date ">{{$review->CREATE_AT}} | <span class="fs-6 fw-bold">{{$review->NAME_PRODUCT}}</span></p>
                                        </div>
                                        <p class="comment text-start fw-normal me-5 mt-3">{{$review->COMMENT}}</p>
                                    </div>
                                </div>
                            </div>
                                <hr>
                            @endforeach
                        </div>
                        <script>
                            const styleTag = document.createElement("style");
                            styleTag.id = "rating-styles";
                            document.head.appendChild(styleTag);
                            console.log("Đã thêm thẻ style #rating-styles vào head.");

                            const addRatingClass = (value) => {
                                console.log(`Hàm addRatingClass được gọi với giá trị: ${value}`); // Kiểm tra xem hàm có được gọi không
                                const ratingClassName = `rating-${String(value).replace(".", "-")}`;
                                const percentage = (100 * value) / 5;

                                const styleTagOnPage = document.querySelector("#rating-styles");

                                if (!styleTagOnPage) {
                                    console.error("Không tìm thấy thẻ style #rating-styles trên trang!"); // Nếu không tìm thấy thẻ style
                                    return;
                                }

                                const newCssRule = `.${ratingClassName} { background-image: linear-gradient(to right, var(--rating-filled-color) ${percentage}%, var(--rating-unfilled-color) ${percentage}%); background-size: 100% 100%; background-repeat: no-repeat; }`;
                                styleTagOnPage.innerHTML += newCssRule;
                                console.log(`Đã thêm CSS rule: ${newCssRule}`); // Kiểm tra xem CSS rule có được tạo và thêm không

                                const ratingBlocksWithDataValue = document.querySelectorAll(
                                    `[data-rating-value="${value}"]`
                                );
                                console.log(`Tìm thấy <span class="math-inline">\{ratingBlocksWithDataValue\.length\} phần tử với data\-rating\-value\="</span>{value}"`); // Kiểm tra số lượng phần tử tìm thấy

                                for (const ratingBlockWithDataValue of ratingBlocksWithDataValue) {
                                    ratingBlockWithDataValue.classList.add(ratingClassName);
                                    console.log(`Đã thêm class "${ratingClassName}" vào phần tử:`, ratingBlockWithDataValue); // Kiểm tra xem class có được thêm vào phần tử cụ thể không
                                }
                            };

                            document.addEventListener('DOMContentLoaded', () => {
                                console.log("DOMContentLoaded đã kích hoạt."); // Kiểm tra xem sự kiện DOMContentLoaded có lắng nghe được không
                                document.querySelectorAll('.many-rating[data-rating-value]').forEach(ratingElement => {
                                    const ratingValue = parseFloat(ratingElement.dataset.ratingValue);
                                    if (!isNaN(ratingValue)) {
                                        addRatingClass(ratingValue);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
                </div>

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
