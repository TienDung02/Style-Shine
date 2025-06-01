<?php

namespace App\Http\Controllers\backend;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
class DashboardController
{
    public function index()
    {
        // Lấy top 5 khách hàng
        $topCustomers = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.full_name',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM orders as invoices2 WHERE invoices2.user_id = users.id) as last_purchase_date')
            )
            ->groupBy('users.id', 'users.full_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Lấy tổng số sản phẩm
        $totalProducts = Product::count(); // Đảm bảo Product model đã được import

        // Lấy danh sách các năm có trong bảng orders
        $years = DB::table('orders')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc') // Sắp xếp giảm dần để năm mới nhất ở đầu dropdown
            ->pluck('year');

        // Chuẩn bị dữ liệu biểu đồ mặc định (ví dụ: theo tháng của năm hiện tại)
        $currentYear = date('Y'); // Lấy năm hiện tại
        $monthlyData = Order::select(
            DB::raw('MONTH(created_at) as period'),
            DB::raw('SUM(total_price) as total')
        )
            ->whereYear('created_at', $currentYear) // Lọc dữ liệu theo năm hiện tại
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('period', 'asc')
            ->get();

        // Chuẩn bị mảng labels và totals cho JavaScript (đảm bảo đủ 12 tháng)
        $initialLabels = range(1, 12);
        $initialTotals = array_fill(1, 12, 0); // Khởi tạo với 0 cho tất cả 12 tháng
        foreach ($monthlyData as $revenue) {
            $initialTotals[$revenue->period] = (float)$revenue->total;
        }

        // Đóng gói dữ liệu biểu đồ ban đầu thành một array để truyền sang JS
        $initialChartData = [
            'labels' => $initialLabels,
            'totals' => array_values($initialTotals) // Lấy giá trị của mảng
        ];

        return view('backend.dashboard.index', compact(
            "totalProducts",
            "topCustomers",
            "years",
            "initialChartData" // Truyền dữ liệu biểu đồ ban đầu
        ));
    }
    public function getStatsData(Request $request)
    {
        $type = $request->input('type', 'month');
        $selectedYear = $request->input('year');

        $labels = [];
        $totals = [];

        $query = Order::query();

        if (!empty($selectedYear)) {
            $query->whereYear('created_at', $selectedYear);
        }

        if ($type === 'month') {
            $monthlyRevenue = $query->select(
                DB::raw('MONTH(created_at) as period'),
                DB::raw('SUM(total_price) as total')
            )
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('period', 'asc')
                ->get();

            $revenueByPeriod = array_fill(1, 12, 0);
            foreach ($monthlyRevenue as $revenue) {
                $revenueByPeriod[$revenue->period] = (float)$revenue->total;
            }

            $labels = range(1, 12);
            $totals = array_values($revenueByPeriod);
        } elseif ($type === 'quarter') {
            $quarterlyRevenue = $query->select(
                DB::raw('QUARTER(created_at) as period'),
                DB::raw('SUM(total_price) as total')
            )
                ->groupBy(DB::raw('QUARTER(created_at)'))
                ->orderBy('period', 'asc')
                ->get();

            $revenueByPeriod = array_fill(1, 4, 0);
            foreach ($quarterlyRevenue as $revenue) {
                $revenueByPeriod[$revenue->period] = (float)$revenue->total;
            }

            $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
            $totals = array_values($revenueByPeriod);
        } else {
            $yearlyRevenue = $query->select(
                DB::raw('YEAR(created_at) as period'),
                DB::raw('SUM(total_price) as total')
            )
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->orderBy('period', 'asc')
                ->get();

            $labels = $yearlyRevenue->pluck('period')->toArray();
            $totals = $yearlyRevenue->pluck('total')->map(fn($total) => (float)$total)->toArray();
        }

        return response()->json([
            'labels' => $labels,
            'totals' => $totals,
            'type' => $type
        ]);
    }

    public function bestSelling(Request $request)
    {
//        dd($request->all());
        $type = $request->input('type', 'month');
        $selectedYear = $request->input('year');





        $orderQuery = Order::query();
        if (!empty($selectedYear)) {
            $orderQuery->whereYear('created_at', $selectedYear);
        }

        $filteredOrderIds = $orderQuery->pluck('id')->toArray();

//        dd($filteredOrderIds);

        if (empty($filteredOrderIds) && !empty($selectedYear)) {
            return response()->json([]);
        }

        $start = null;
        $end = null;
        $now = now();

        if ($type === 'month') {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();
        } elseif ($type === 'quarter') {
            $start = $now->copy()->firstOfQuarter();
            $end = $now->copy()->lastOfQuarter();
        } elseif ($type === 'year') {
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }
        $totalAllQuery = DB::table('order_details')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->whereIn('orders.id', $filteredOrderIds);

        if ($start && $end) {
            $totalAllQuery->whereBetween('orders.created_at', [$start, $end]);
        }

        $totalAll = $totalAllQuery->sum('order_details.quantity');

        if ($totalAll == 0) {
            return response()->json([]);
        }

        $topProductsQuery = DB::table('order_details')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->whereIn('orders.id', $filteredOrderIds);

        if ($start && $end) {
            $topProductsQuery->whereBetween('orders.created_at', [$start, $end]);
        }

        $topProducts = $topProductsQuery->select('products.name', DB::raw('SUM(order_details.quantity) as total'))
            ->groupBy('products.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
//        dd($topProductsQuery);

        $topFormatted = [];
        $topTotalPercent = 0;

        foreach ($topProducts as $item) {
            $percent = round($item->total / $totalAll * 100, 2);
            $topTotalPercent += $percent;
            $topFormatted[] = [
                'name' => $item->name,
                'percent' => $percent
            ];
        }

        $otherPercent = round(100 - $topTotalPercent, 2);

        if ($otherPercent > 0 && count($topProducts) >= 5) {
            $topFormatted[] = [
                'name' => 'Orthers',
                'percent' => $otherPercent
            ];
        } elseif ($otherPercent > 0 && count($topProducts) < 5 && count($topProducts) > 0) {
            if ($otherPercent >= 1) {
                $topFormatted[] = [
                    'name' => 'Orthers',
                    'percent' => $otherPercent
                ];
            }
        }


        return response()->json($topFormatted);
    }



}
