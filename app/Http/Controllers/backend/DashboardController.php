<?php

namespace App\Http\Controllers\backend;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Product;
class DashboardController
{
    public function index()
    {
//        $totalRevenue = Invoice::sum('total_price');
//
//        $monthlyRevenue = Invoice::select(
//            DB::raw('MONTH(created_at) as month'),
//            DB::raw('SUM(total_price) as total')
//        )
//            ->groupBy(DB::raw('MONTH(created_at)'))
//            ->get();
//        return view('backend.dashboard.index', compact('monthlyRevenue', 'totalRevenue'));
        $topCustomers = DB::table('invoice_details')
            ->join('invoices', 'invoice_details.id_invoice', '=', 'invoices.id')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->select(
                'customers.id',
                'customers.cus_name',
                DB::raw('SUM(invoice_details.quality) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM invoices as invoices2 WHERE invoices2.customer_id = customers.id) as last_purchase_date')
            )
            ->groupBy('customers.id', 'customers.cus_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
//        dd($topCustomers);
        $totalProducts = Product::count();

        return view('backend.dashboard.index', compact("totalProducts", "topCustomers"));
    }
    public function getStatsData(Request $request)
    {
//        dd($request->all());
        // Lấy kiểu thống kê từ request (mặc định là 'month')
        $type = $request->input('type', 'month');

        $labels = [];
        $totals = [];

        if ($type === 'month') {
            $monthlyRevenue = Invoice::select(
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
            // Thống kê theo quý
            $quarterlyRevenue = Invoice::select(
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
            // Thống kê theo năm
            $yearlyRevenue = Invoice::select(
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
        $now = now();
        $type = $request->type;
//        dd($request->all());
        switch ($type) {
            case 'month':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;
            case 'quarter':
                $start = $now->copy()->firstOfQuarter();
                $end = $now->copy()->lastOfQuarter();
                break;
            case 'year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        $totalAll = DB::table('invoice_details')
            ->join('invoices', 'invoices.id', '=', 'invoice_details.id_invoice')
            ->whereBetween('invoices.created_at', [$start, $end])
            ->sum('invoice_details.quality');

        if ($totalAll == 0) {
            return response()->json([]);
        }

        // Top 5 sản phẩm
        $topProducts = DB::table('invoice_details')
            ->join('products', 'products.id_product', '=', 'invoice_details.id_product')
            ->join('invoices', 'invoices.id', '=', 'invoice_details.id_invoice')
            ->whereBetween('invoices.created_at', [$start, $end])
            ->select('products.name_product', DB::raw('SUM(invoice_details.quality) as total'))
            ->groupBy('products.name_product')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topFormatted = [];
        $topTotal = 0;
        foreach ($topProducts as $item) {
            $percent = round($item->total / $totalAll * 100, 2);
            $topTotal += $percent;
            $topFormatted[] = [
                'name' => $item->name_product,
                'percent' => $percent
            ];
        }

        // Phần còn lại
        $otherPercent = round(100 - $topTotal, 2);

        if ($otherPercent > 0) {
            $topFormatted[] = [
                'name' => 'Orthers',
                'percent' => $otherPercent
            ];
        }
//        dd(response()->json($topFormatted));
        return response()->json($topFormatted);
    }



}
