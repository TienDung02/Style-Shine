$(function() {
    "use strict";
    $(function() {
        $(".preloader").fadeOut();
    });

    // ==============================================================
    // This is for the top header part and sidebar part
    // ==============================================================
    var set = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        var topOffset = 80;
        if (width < 1170) {
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
            $(".sidebartoggler i").addClass("ti-menu");
        } else {
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
            //$(".sidebartoggler i").removeClass("ti-menu");
        }

        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $(".page-wrapper").css("min-height", (height) + "px");
        }
    };
    $(window).ready(set);
    $(window).on("resize", set);

    // topbar stickey on scroll
    $(".fix-header .topbar").stick_in_parent({});

    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").click(function() {
        $("body").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
        $(".nav-toggler i").addClass("ti-close");
    });
    $(".sidebartoggler").on('click', function() {
        //$(".sidebartoggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
    });

    // ==============================================================
    // Auto select left navbar
    // ==============================================================
    $(function () {
        var path = window.location.pathname.split('/')[1]; // Lấy segment đầu tiên
        var basePath = '/' + path;

        var element = $('ul#sidebarnav a').filter(function () {
            return this.pathname.startsWith(basePath);
        }).addClass('active').parent().addClass('active');

        while (true) {
            if (element.is('li')) {
                element = element.parent().addClass('in').parent().addClass('active');
            } else {
                break;
            }
        }
    });

    // ==============================================================
    //tooltip
    // ==============================================================
    $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // ==============================================================
        // Sidebarmenu
        // ==============================================================
    $(function() {
        $('#sidebarnav').metisMenu();
    });
    // ==============================================================
    // Slimscrollbars
    // ==============================================================
    $('.scroll-sidebar').slimScroll({
        position: 'left',
        size: "5px",
        height: '100%',
        color: '#dcdcdc'
    });
    // ==============================================================
    // Resize all elements
    // ==============================================================


    // ==============================================================
    // Slimscrollbars
    // ==============================================================
    $('#otp').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');

        if (this.value.length > 6) {
            this.value = this.value.slice(0, 6);
        }
    });
    // ==============================================================
    // Resize all elements
    // ==============================================================


    // ==============================================================
    // Check Password Update
    // ==============================================================
    $('.confirm_password, .new_password').on('input', function() {

        var new_pwd = $('.new_password').val();
        var confirmPassword = $('.confirm_password').val();

        if (new_pwd !== confirmPassword && confirmPassword != '') {
            console.log('ádavsd')
            $('.btn-submit-update').prop('disabled', true);
            $('.notification').removeClass('d-none');
        }else {
            $('.btn-submit-update').prop('disabled', false);
            $('.notification').addClass('d-none');
        }
    });
    // ==============================================================
    // Check Password Update
    // ==============================================================
    $("body").trigger("resize");




    // ==============================================================
    // Ajax Change Type Chart Main
    // ==============================================================

    let chartInstance = null;
    let currentType = 'month';

    function drawChart(labels, totals, type) {
        if (chartInstance) {
            chartInstance.destroy();
        }

        const ctx = document.getElementById('salesChart').getContext('2d');
        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tổng Doanh Thu (VND)',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barThickness: type === 'month' ? 20 : (type === 'quarter' ? 30 : 40)
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: { display: false, text: 'Tổng Doanh Thu ($)' },
                        ticks: { font: { size: 12 } }
                    },
                    x: {
                        title: {
                            display: false,
                            text: type === 'month' ? 'Tháng' : (type === 'quarter' ? 'Quý' : 'Năm')
                        },
                        ticks: { font: { size: 12 } }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    function updateChart() {
        let selectedYear = $('#yearFormat').val();

        if (currentType === 'year') {
            selectedYear = '';
            $('#yearFormat').closest('div').addClass('d-none');
            console.log('aaaaaaa')
        } else {
            $('#yearFormat').closest('div').removeClass('d-none');
        }

        console.log('Fetching data for Type:', currentType, 'Year:', selectedYear);

        $.ajax({
            url: $('#value-url').attr('data-url'),
            method: 'GET',
            data: {
                type: currentType,
                year: selectedYear
            },
            success: function(response) {
                drawChart(response.labels, response.totals, response.type);
            },
            error: function(xhr) {
                console.error('Lỗi khi lấy dữ liệu:', xhr);
                toastr.error('Lỗi khi tải dữ liệu biểu đồ.');
            }
        });
    }
    // ==============================================================
    // End Ajax Change Type Chart Main
    // ==============================================================

    // ==============================================================
    // Show Chart Main
    // ==============================================================
    $(document).ready(function () {
        if (typeof initialChartData !== 'undefined' && initialChartData && initialChartData.labels && initialChartData.totals) {
            drawChart(initialChartData.labels, initialChartData.totals, currentType);
        } else {
            console.warn("initialChartData is not defined or empty. Loading chart via AJAX.");
            updateChart();
        }
        $('#yearFormat').on('change', function () {
            updateChart();
        });

        $('.list-inline-main a').on('click', function(e) {
            e.preventDefault();
            $('.list-inline-main li').removeClass('active-chart-main');
            $(this).parent().addClass('active-chart-main');

            currentType = $(this).data('type');
            updateChart();
        });
        updateChart();
    });
    // ==============================================================
    // End Show Chart Main
    // ==============================================================









    // ==============================================================
    // Ajax Change Type Chart Best Selling
    // ==============================================================
    let bestSellingChart = null;
    let currentBestSellingType = 'month'; // Biến để theo dõi loại thống kê (tháng/quý/năm) cho biểu đồ sản phẩm bán chạy

    function drawBestSellingChart(labels, values) {
        if (bestSellingChart) {
            bestSellingChart.destroy();
        }

        const colors = [
            '#36A2EB', '#4BC0C0', '#9966FF', '#FF6384', '#FFCE56', '#CCCCCC' // Thêm màu cho "Orthers"
        ];

        const ctx = document.getElementById('bestSellingChart').getContext('2d');
        bestSellingChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors.slice(0, labels.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                },
                cutout: '50%'
            }
        });
    }

    function updateBestSellingChart() {
        let selectedYear = $('#yearFormat-bestSelling').val();


        console.log('Fetching data for Type Year:', selectedYear);
        $.ajax({
            url: $('#product-chart-url').data('url'),
            method: 'GET',
            data: {
                type: currentBestSellingType,
                year: selectedYear
            },
            success: function(response) {
                if (response.length === 0) { // Xử lý trường hợp không có dữ liệu
                    // Có thể hiển thị một thông báo hoặc biểu đồ rỗng
                    if (bestSellingChart) {
                        bestSellingChart.destroy();
                    }
                    const ctx = document.getElementById('bestSellingChart').getContext('2d');
                    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                    // Thêm text thông báo không có dữ liệu
                    ctx.font = "20px Arial";
                    ctx.textAlign = "center";
                    ctx.fillText("Không có dữ liệu trong khoảng thời gian này.", ctx.canvas.width/2, ctx.canvas.height/2);
                    return;
                }

                const labels = response.map(item => item.name);
                const values = response.map(item => item.percent);

                drawBestSellingChart(labels, values);
            },
            error: function(xhr) {
                console.error('Lỗi khi lấy dữ liệu sản phẩm bán chạy:', xhr);
                toastr.error('Lỗi khi tải dữ liệu sản phẩm bán chạy.');
            }
        });
    }

// Khởi tạo biểu đồ khi DOM sẵn sàng
    $(document).ready(function() {
        // Gọi hàm cập nhật lần đầu khi trang tải
        updateBestSellingChart();

        // Lắng nghe sự kiện thay đổi của dropdown năm cho Best Selling Products
        $('#yearFormat-bestSelling').on('change', function() {
            console.log('change')
            updateBestSellingChart();
        });

        // Lắng nghe sự kiện click cho các nút Month/Quarter/Year của Best Selling Products
        // Đảm bảo ID các nút là duy nhất (ví dụ: btnMonth-bestSelling)
        $('#btnMonth-bestSelling').on('click', function() {
            currentBestSellingType = 'month';
            console.log('month')
            updateBestSellingChart();
        });
        $('#btnQuarter-bestSelling').on('click', function() {
            currentBestSellingType = 'quarter'; // Cập nhật loại
            console.log('quarter')

            updateBestSellingChart();

        });
        $('#btnYear-bestSelling').on('click', function() {
            currentBestSellingType = 'year'; // Cập nhật loại
            console.log('year')
            updateBestSellingChart();
        });

        // Xử lý active class cho các nút Best Selling
        $('.list-inline-bestSelling a').on('click', function(e) {
            e.preventDefault();
            $('.list-inline-bestSelling li').removeClass('active-chart-bestSelling'); // Sửa class active
            $(this).parent().addClass('active-chart-bestSelling');
        });
    });

    // ==============================================================
    // End Ajax Change Type Chart Best Selling
    // ==============================================================


    // -----------------------------------------Alert Confirm Delete----------------------------------------------------
    function confirmDelete(formId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var _this = $(this);
        var id_form = _this.attr('data-id');
        confirmDelete('delete-form-'+id_form);
    })
    // ---------------------------------------------------------------------------------------------

    //------------------------------ Ajax show Limit ---------------------------//
    $(document).on('change', '#show-limit',function() {
        var urlParams = new URLSearchParams(window.location.search);
        var keyword = urlParams.get('keyword');
        var limit = $(this).val();

        $.ajax({
            url: $('#get_limit').attr('data-url'),
            type: 'GET',
            data: {
                'keyword': keyword,
                'limit': limit,
            },
            success: function(data) {
                var html = $(data).children();
                $('#get-result-search').html(html);
                var newUrl = new URL(window.location.href);
                newUrl.searchParams.set('keyword', keyword);
                newUrl.searchParams.set('type', type);
                newUrl.searchParams.set('limit', limit);
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    //------------------------------------------------------------------------------//

    //------------------------------ Ajax Next Page Paginate ---------------------------//
    $(document).on('click', '.page-link',function() {
        if ($(this).hasClass('disabled')) {
            e.preventDefault();
            return;
        }
        const fullUrl = $(this).data('href');
        if (!fullUrl) return;


        const urlParams = new URLSearchParams(fullUrl.split('?')[1]);
        const keyword = urlParams.get('keyword');
        var limit = urlParams.get('limit');
        const page = urlParams.get('page');
        if (!limit || isNaN(limit)) {
            limit = 5;
        }

        $.ajax({
            url: $('#get_limit').attr('data-url'),
            type: 'GET',
            data: {
                'keyword': keyword,
                'limit': limit,
                'page': page,
            },
            success: function(data) {
                var html = $(data).children();
                $('#get-result-search').html(html);
                var newUrl = new URL(window.location.href);
                newUrl.searchParams.set('keyword', keyword);
                newUrl.searchParams.set('limit', limit);
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    //------------------------------------------------------------------------------//


    //------------------------------ Ajax show Result Search ---------------------------//
    $(document).ready(function() {
        let searchTimer;
        function fetchProducts(page = 1) {
            const keyword = $('#search-input').val();
            var limit = $('#show-limit').val();
            const currentUrl = window.location.href;
            $.ajax({
                url: $('#url_search').attr('data-url'),
                type: 'GET',
                data: {
                    'keyword': keyword,
                    'page': page,
                    'limit': limit
                },
                success: function(data) {
                    var html = $(data).children();
                    $('#get-result-search').html(html);
                    var newUrl = new URL(window.location.href);
                    newUrl.searchParams.set('keyword', keyword);
                    newUrl.searchParams.set('page', page); // Cập nhật page
                    window.history.pushState({path: newUrl.href}, '', newUrl.href);
                },
                error: function(xhr, status, error) {
                    console.error("Lỗi khi tìm kiếm:", xhr.responseText);
                    $('#get-result-search').html('<p class="text-danger">Đã xảy ra lỗi khi tải dữ liệu.</p>');
                }
            });
        }

        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                fetchProducts(1);
            }, 300);
        });
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            clearTimeout(searchTimer);
            fetchProducts(1);
        });
        $(document).on('click', '#product-table-container .pagination-links a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchProducts(page);
        });
        if (window.location.search.includes('keyword')) {
            const initialKeyword = new URLSearchParams(window.location.search).get('keyword');
            const initialPage = new URLSearchParams(window.location.search).get('page') || 1;
            $('#search-input').val(initialKeyword);
            fetchProducts(initialPage);
        } else {
        }
    });
    //---------------------------------------------------------//


    /*----------------------------------------------------*/
    /*  Preview Image
    /*----------------------------------------------------*/
    $('#fileInput2').on('change', function () {
        let $input = $(this);

        if ($input.val().length > 0) {
            let fileReader = new FileReader();

            fileReader.onload = function (data) {
                // Set ảnh preview
                $('.image-preview').attr('src', data.target.result).css('display', 'block');

                // Nếu ảnh có src => xóa thẻ <i>
                if ($('#image_product').attr('src')) {
                    $('.controlContainer i').remove();
                }
            }

            fileReader.readAsDataURL($input.prop('files')[0]);
        }
    });
    $(document).ready(function () {
        const imgSrc = $('#image_product').attr('src');
        if (imgSrc && imgSrc.trim() !== '') {
            $('.controlContainer i').remove();
        }
    });
    /*----------------------------------------------------*/
    /*  End Preview Image
    /*----------------------------------------------------*/

    /*----------------------------------------------------*/
    /*  Upload File Get File Name
    /*----------------------------------------------------*/
    // $('.fileInput2').on('change', function () {
    //     var parent = $(this).parents('.controlContainer').first();
    //     var fileName = $(this)[0].files[0].name;
    //     $(parent).find('.inputFileMaskText2').first().val(fileName);
    // });
    /*----------------------------------------------------*/
    /*  End Upload File Get File Name
    /*----------------------------------------------------*/

    /*----------------------------------------------------*/
    /*  Summernote
    /*----------------------------------------------------*/
    // $.getScript('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js', function ()
    // {
    //     $('.summernote').summernote();
    // });
    // $('.note-btn').on('click', function () {
    //     $('.modal-backdrop').remove();
    // })
    // $('.close').on('click', function() {
    //     console.log('aaaaaaaa');
    //     $(this).closest('.note-model').removeClass('show');
    // });


    $(document).ready(function() {
        $('.summernote').summernote();
    });
    /*----------------------------------------------------*/
    /*  End Summernote
    /*----------------------------------------------------*/



    /*----------------------------------------------------*/
    /*  Add & Edit Category
    /*----------------------------------------------------*/
    $(document).on('click', '#add-new', function () {
        var url_store = $('#store_category').data('url');
        console.log('URL store:', url_store);

        $('#modalTitle').text('Thêm danh mục');
        $('#categoryForm').attr('action', url_store);
        $('#form-method').val('POST');
        $('#category-id').val('');
        $('#category-name').val('');
        $('#category-parent').val('');
    });

    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');

        $('#modalTitle').text('Sửa danh mục');
        let baseUrl = $(this).data('url');
        $('#categoryForm').attr('action', baseUrl);
        console.log(baseUrl)
        $('#form-method').val('PUT');
        $('#category-id').val(id);
        $('#category-name').val(name);
        $('#category-parent').val(parent);
    });
    /*----------------------------------------------------*/
    /*  End Add & Edit Category
    /*----------------------------------------------------*/

    /*----------------------------------------------------*/
    /*  Rating
    /*----------------------------------------------------*/
    const ratings = document.querySelectorAll(".circle-rating");
    ratings.forEach((rating) => {
        const ratingContent = rating.innerHTML;
        const ratingScore = parseInt(ratingContent, 10);
        const scoreClass =
            ratingScore < 40 ? "bad" : ratingScore < 60 ? "meh" : "good";
        rating.classList.add(scoreClass);
        const ratingColor = window.getComputedStyle(rating).backgroundColor;
        const gradient = `background: conic-gradient(${ratingColor} ${ratingScore}%, transparent 0 100%)`;
        rating.setAttribute("style", gradient);
        rating.innerHTML = `<span>${ratingScore} ${
            ratingContent.indexOf("%") >= 0 ? "<small>%</small>" : ""
        }</span>`;
    });
    // -----------------------------------------------------

    $(document).ready(function() {
        var score = parseFloat($('#score').text());
        var stars = $('.star');
        console.log(score)
        stars.each(function(index) {
            var fill = 0;
            if (index + 1 <= score) {
                fill = 100;
            } else if (index < score) {
                fill = (score - index) * 100;
            }
            $(this).css('--star-rate', fill + '%');
        });
    });

    $(document).ready(function() {
        const $stars = $('.stars .star');

        $stars.each(function(index) {
            const $star = $(this);
            const starRateValue = $star.css('--star-rate');


            if (starRateValue) {
                const numericValue = parseFloat(starRateValue.replace('%', ''));
            }
        });

        const $ratingTooltip = $('.tooltip.rating');
        if ($ratingTooltip.length) {
            const dataRating = $ratingTooltip.attr('data-rating');
        }
    });

    $(document).on('click', '.page-link',function() {
        if ($(this).hasClass('disabled')) {
            e.preventDefault();
            return;
        }
        const fullUrl = $(this).data('href');
        if (!fullUrl) return;


        const urlParams = new URLSearchParams(fullUrl.split('?')[1]);
        const keyword = urlParams.get('keyword');
        var limit = urlParams.get('limit');
        const page = urlParams.get('page');
        if (!limit || isNaN(limit)) {
            limit = 5;
        }

        $.ajax({
            url: $('#get_limit').attr('data-url'),
            type: 'GET',
            data: {
                'keyword': keyword,
                'limit': limit,
                'page': page,
            },
            success: function(data) {
                var html = $(data).children();
                $('#get-result-search').html(html);
                var newUrl = new URL(window.location.href);
                newUrl.searchParams.set('keyword', keyword);
                newUrl.searchParams.set('limit', limit);
                window.history.pushState({path: newUrl.href}, '', newUrl.href);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    /*----------------------------------------------------*/
    /*  End Rating
    /*----------------------------------------------------*/

    $(document).ready(function() {
        $('#time_period_select').change(function() {
            var selectedValue = $(this).val();

            if (selectedValue) {
                $.ajax({
                    url: $('#get_change_time').attr('data-url'),
                    method: 'GET',
                    data: {
                        time_period: selectedValue
                    },
                    success: function(response) {
                        $('#top-customers-table-container').html(response);
                        console.log('Bảng đã được cập nhật thành công.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Đã xảy ra lỗi:', error);
                    }
                });
            }
        });
    });


    //------------------------------------------------------------------------------//
});
