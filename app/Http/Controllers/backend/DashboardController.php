<?php

namespace App\Http\Controllers\backend;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
class DashboardController
{
    public function index()
    {
        $date = Carbon::now();
        $topCustomers = DB::table('invoice_detail')
            ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                'customer.username',
                'customer.cus_name',
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM invoice as invoices2 WHERE invoices2.username = customer.username) as last_purchase_date')
            )
            ->groupBy('customer.username', 'customer.cus_name')->whereMonth('created_at', $date->month)
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $totalProducts = Product::count();

        $years = DB::table('invoice')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $currentYear = date('Y');
        $monthlyData = Order::select(
            DB::raw('MONTH(created_at) as period'),
            DB::raw('SUM(total_price) as total')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('period', 'asc')
            ->get();

        $initialLabels = range(1, 12);
        $initialTotals = array_fill(1, 12, 0);
        foreach ($monthlyData as $revenue) {
            $initialTotals[$revenue->period] = (float)$revenue->total;
        }

        $initialChartData = [
            'labels' => $initialLabels,
            'totals' => array_values($initialTotals)
        ];

        return view('backend.dashboard.index', compact(
            "totalProducts",
            "topCustomers",
            "years",
            "initialChartData"
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
        $type = $request->input('type', 'month');
        $selectedYear = $request->input('year');

        $orderQuery = Order::query();
        if (!empty($selectedYear)) {
            $orderQuery->whereYear('created_at', $selectedYear);
        }

        $filteredOrderIds = $orderQuery->pluck('id')->toArray();

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
        $totalAllQuery = DB::table('invoice_detail')
            ->join('invoice', 'invoice.id', '=', 'invoice_detail.invoice_id')
            ->whereIn('invoice.id', $filteredOrderIds);
        if ($start && $end) {
            $totalAllQuery->whereBetween('invoice.created_at', [$start, $end]);
        }

        $totalAll = $totalAllQuery->sum('invoice_detail.quantity');

        if ($totalAll == 0) {
            return response()->json([]);
        }
        $topProductsQuery = DB::table('invoice_detail')
            ->join('product', 'product.id_product', '=', 'invoice_detail.product_id')
            ->join('invoice', 'invoice.id', '=', 'invoice_detail.invoice_id')
            ->whereIn('invoice.id', $filteredOrderIds);

        if ($start && $end) {
            $topProductsQuery->whereBetween('invoice.created_at', [$start, $end]);
        }

        $topProducts = $topProductsQuery->select('product.name_product', DB::raw('SUM(invoice_detail.quantity) as total'))
            ->groupBy('product.name_product')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topFormatted = [];
        $topTotalPercent = 0;

        foreach ($topProducts as $item) {
            $percent = round($item->total / $totalAll * 100, 2);
            $topTotalPercent += $percent;
            $topFormatted[] = [
                'name' => $item->name_product,
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
    public function TopCustomer(Request $request)
    {
        $now = now();
        $time = $request->time_period;
//        if ($time === 'month') {
//            $time = $date->month;
//        } elseif ($time === 'quarter') {
//            $time = $date->quarter;
//        } elseif ($time === 'year') {
//            $time = $date->year;
//        }
        if ($time === 'month') {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();
        } elseif ($time === 'quarter') {
            $start = $now->copy()->firstOfQuarter();
            $end = $now->copy()->lastOfQuarter();
        } elseif ($time === 'year') {
            $start = $now->copy()->firstOfYear();
            $end = $now->copy()->lastOfYear();
        }
        $topCustomers = DB::table('invoice_detail')
            ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                'customer.username',
                'customer.cus_name',
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM invoice as invoices2 WHERE invoices2.username = customer.username) as last_purchase_date')
            )
            ->groupBy('customer.username', 'customer.cus_name')->whereBetween('invoice.created_at', [$start, $end])
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
        return view('backend.dashboard.ajax.top-customer', compact('topCustomers'));
    }
}
