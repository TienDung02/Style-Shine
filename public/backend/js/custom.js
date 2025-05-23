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
        var topOffset = 70;
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
    $(function() {
        var url = window.location;
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href == url;
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

    function updateChart(type) {

        $.ajax({
            url: $('#value-url').attr('data-url'),
            method: 'GET',
            data: { type: type },
            success: function(response) {
                // Hủy biểu đồ cũ nếu nó tồn tại
                if (chartInstance) {
                    chartInstance.destroy();
                }

                const ctx = document.getElementById('salesChart').getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Tổng Doanh Thu (VND)', // Đã thêm lại label
                            data: response.totals,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            barThickness: type === 'month' ? 20 : type === 'quarter' ? 30 : 40
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: false, // Hiển thị lại title nếu cần
                                    text: 'Tổng Doanh Thu (VND)',
                                    font: { size: 16, weight: 'bold' },
                                    color: '#333'
                                },
                                ticks: { font: { size: 12 }, color: '#666' },
                                grid: { color: '#e0e0e0' }
                            },
                            x: {
                                title: {
                                    display: false,
                                    text: type === 'month' ? 'Tháng' : type === 'quarter' ? 'Quý' : 'Năm',
                                    font: { size: 16, weight: 'bold' },
                                    color: '#333'
                                },
                                ticks: { font: { size: 12 }, color: '#666' },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            },
            error: function(xhr) {
                console.error('Lỗi khi lấy dữ liệu:', xhr);
            }
        });
    }
    // ==============================================================
    // End Ajax Change Type Chart Main
    // ==============================================================

    // ==============================================================
    // Show Chart Main
    // ==============================================================
    $(document).ready(function() {
        if (typeof monthlyData !== 'undefined' && monthlyData && monthlyData.labels && monthlyData.totals) {
            var sortedData = monthlyData.labels
                .map((label, index) => ({ label: parseInt(label), total: parseFloat(monthlyData.totals[index]) }))
                .sort((a, b) => a.label - b.label);

            var sortedLabels = sortedData.map(item => item.label);
            var sortedTotals = sortedData.map(item => item.total);

            var ctx = document.getElementById('salesChart').getContext('2d');
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sortedLabels,
                    datasets: [{
                        label: 'Total Revenue (VND)',
                        data: sortedTotals,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        barThickness: 20
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: false,
                                text: 'Tổng Doanh Thu (VND)',
                                font: { size: 16, weight: 'bold' },
                                color: '#333'
                            },
                            ticks: { font: { size: 12 }, color: '#666' },
                            grid: { color: '#e0e0e0' }
                        },
                        x: {
                            title: {
                                display: false,
                                text: 'Tháng',
                                font: { size: 16, weight: 'bold' },
                                color: '#333'
                            },
                            ticks: { font: { size: 12 }, color: '#666' },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        } else {
            console.warn("monthlyData is not defined or empty. Initial chart might not be drawn.");

        }
        updateChart('month');
        $('#btnMonth').on('click', function() { updateChart('month'); });
        $('#btnQuarter').on('click', function() { updateChart('quarter'); });
        $('#btnYear').on('click', function() { updateChart('year'); });
    });

    $('.list-inline-main a').on('click', function(e) {
        e.preventDefault();
        $('.list-inline-main li').removeClass('active-chart-main');
        $(this).parent().addClass('active-chart-main');
    });
    // ==============================================================
    // End Show Chart Main
    // ==============================================================









    // ==============================================================
    // Ajax Change Type Chart Best Selling
    // ==============================================================
    let bestSellingChart = null;

    function updateBestSellingChart(type) {
        $.ajax({
            url: $('#product-chart-url').data('url'),
            method: 'GET',
            data: { type: type },
            success: function(response) {
                // Huỷ biểu đồ cũ nếu có
                if (bestSellingChart) {
                    bestSellingChart.destroy();
                }

                const labels = response.map(item => item.name);
                const values = response.map(item => item.percent);

                const colors = [
                    '#36A2EB', '#4BC0C0', '#9966FF', '#FF6384', '#FFCE56', '#CCCCCC'
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
                        cutout: '50%' // Làm rỗng phần giữa (donut)
                    }
                });
            },
            error: function(xhr) {
                console.error('Lỗi khi lấy dữ liệu sản phẩm bán chạy:', xhr);
            }
        });
    }

    updateBestSellingChart('month');
    $('#btnMonth-bestSelling').on('click', function() {
        console.log('a')
        updateBestSellingChart('month');
    });
    $('#btnQuarter-bestSelling').on('click', function() {
        updateBestSellingChart('quarter');
    });
    $('#btnYear-bestSelling').on('click', function() {
        updateBestSellingChart('year');
    });


    $('.list-inline-bestSelling a').on('click', function(e) {
        e.preventDefault();
        $('.list-inline li').removeClass('active-chart-bestSelling');
        $(this).parent().addClass('active-chart-bestSelling');
        const selectedType = $(this).data('type');
        updateBestSellingChart(selectedType);
    });

    // ==============================================================
    // End Ajax Change Type Chart Best Selling
    // ==============================================================

});
