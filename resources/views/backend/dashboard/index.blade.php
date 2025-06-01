@extends('backend.layouts.layout')
@section('content')



        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="card-block p-20">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap justify-content-between">
                                            <div>
                                                <h3 class="card-title">Sales Overview</h3>
                                                <h6 class="card-subtitle">Total Revenue ($)</h6>
                                            </div>
                                            <div class="select">
                                                <select name="format" id="yearFormat">
                                                    @foreach($years as $year)
                                                        <option value="{{$year}}" {{ $year == date('Y') ? 'selected' : '' }}>{{$year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="ml-auto">
                                                <div class="ml-auto">
                                                    <ul class="list-inline-main list-inline">
                                                        <li id="btnMonth" class="active-chart-main">
                                                            <a data-type="month" class="border-bottom"><h6 class="text-muted text-success mb-0">Month</h6></a>
                                                        </li>
                                                        <li id="btnQuarter">
                                                            <a data-type="quarter"><h6 class="text-muted text-info mb-0">Quarter</h6></a>
                                                        </li>
                                                        <li id="btnYear">
                                                            <a data-type="year"><h6 class=" text-primary mb-0">Year</h6></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <span id="value-url" data-url="{{route("dashboard.data")}}"></span>
                                        <canvas height="380" width="1000" id="salesChart"></canvas>
                                        <script>
                                            var initialChartData = @json($initialChartData);
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="card">
                            <div class="card-block p-20">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="card-title">Best Selling Products</h3>
                                        <h6 class="card-subtitle">There are a total of {{$totalProducts}} products.</h6>
                                    </div>

                                </div>
                                <canvas height="380" width="480" id="bestSellingChart"></canvas>
                                <span id="product-chart-url" data-url="{{ route('dashboard.bestSelling') }}"></span>
                            </div>

                            <div>
                                <hr class="m-t-0 m-b-0">
                            </div>
                            <div class="card-block text-center ">
                                <ul class="list-inline m-b-0 list-inline-bestSelling">
                                    <li id="btnMonth-bestSelling" class="active-chart-bestSelling">
                                        <a><h6 class="text-muted text-info mb-0">Month</h6> </a>
                                    </li>
                                    <li id="btnQuarter-bestSelling">
                                        <a><h6 class="text-muted  text-primary mb-0">Quarter</h6> </a>
                                    </li>
                                    <li id="btnYear-bestSelling">
                                        <a href=""><h6 class="text-muted  text-success">Year</h6></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- Row -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card p-20">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-3">
                                        <h4 class="card-title">Potential customer statistics</h4>
                                        <h6 class="card-subtitle">Top 5 customers who bought the most</h6>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Quantity Purchased</th>
                                            <th>Last Purchase Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $count = 1 @endphp
                                        @foreach($topCustomers as $topCustomer)
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{$topCustomer->full_name}}</td>
                                                <td>{{$topCustomer->total_quantity}}</td>
                                                <td>{{ \Carbon\Carbon::parse($topCustomer->last_purchase_date)->format('d-m-Y') }}</td>
                                                @php $count++ @endphp
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer"> © 2017 Material Pro Admin by wrappixel.com </footer>
        </div>
    </div>
{{--    <script>--}}
{{--        var monthlyData = {--}}
{{--            labels: @json($monthlyRevenue->pluck('month')),--}}
{{--            totals: @json($monthlyRevenue->pluck('total'))--}}
{{--        };--}}
{{--    </script>--}}
@endsection
