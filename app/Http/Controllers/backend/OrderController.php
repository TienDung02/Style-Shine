<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade;
use Barryvdh\DomPDF\PDF;
class OrderController
{
    public function index()
    {
        $total = Order::count();
        $data = Order::query()->paginate(5);
        return view('backend.order.index', compact("total", "data"));
    }

    public function getLimit (Request $request) {
        $data = Order::query();
        $keyword = $request->keyword;

        $limit = $request->input('limit', 5);
        if ($keyword == null) {
            $data = $data->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        return view('backend.order.ajax.table', compact('data'));
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit ?? 5;
        if ($keyword == null) {
            $data = DB::table('invoice')
                ->join('customer', 'invoice.username', '=', 'customer.username')
                ->select(
                    'invoice.id',
                    'invoice.total_price',
                    'invoice.payment_method',
                    'invoice.created_at',
                    'customer.username',
                )
                ->orderBy('invoice.id')
                ->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        return view('backend.order.ajax.table', compact('data'));
    }
    public function result_search($keyword, $limit = 5)
    {
        $data = DB::table('invoice')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                'invoice.id',
                'invoice.total_price',
                'invoice.payment_method',
                'invoice.created_at',
                'customer.username',
            )
            ->where(function($query) use ($keyword) {
                $query->where('customer.username', 'like', "%$keyword%")
                    ->orWhere('invoice.payment_method', 'like', "%$keyword%");
            })
            ->orderBy('invoice.id')
            ->paginate($limit);
        return $data;
    }
    public function view($id)
    {
        $order = DB::table('invoice')
            ->select('invoice.*', 'customer.*')
            ->leftJoin('customer', 'invoice.username', '=', 'customer.username')
            ->where('invoice.id', '=', $id)
            ->first();
        $data = OrderDetail::query()->where('invoice_id', $id)->get();
        return view('backend.order.view', compact('data', 'order'));
    }

    public function generateReceipt($id) {
        $order = DB::table('invoice')
            ->select('invoice.*', 'customer.*')
            ->leftJoin('customer', 'invoice.username', '=', 'customer.username')
            ->where('invoice.id', '=', $id)
            ->first();
        $data = OrderDetail::query()->where('invoice_id', $id)->get();
//        return view('backend.order.ajax.receipt_partial', compact('data', 'order'));
        $pdf = app(PDF::class)->loadView('backend.order.ajax.receipt_partial', compact('order', 'data'));
        return $pdf->download('order_receipt_'.$id.'.pdf');
    }
}
