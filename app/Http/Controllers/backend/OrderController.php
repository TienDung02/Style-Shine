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
class OrderController
{
    public function index()
    {
        $total = Order::count();
        $data = Order::query()->where('user_id','!=', 1)->paginate(5);
        return view('backend.order.index', compact("total", "data"));
    }

    public function getLimit (Request $request) {
        $data = Order::query()->where('user_id','!=', 1);
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
            $data = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(
                    'orders.id',
                    'orders.total_price',
                    'orders.payment_method',
                    'orders.status',
                    'orders.updated_at',
                    'users.full_name',
                )
                ->where('users.role', 0)
                ->orderBy('orders.id')
                ->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        return view('backend.order.ajax.table', compact('data'));
    }
    public function result_search($keyword, $limit = 5)
    {
        $data = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id',
                'orders.total_price',
                'orders.payment_method',
                'orders.status',
                'orders.updated_at',
                'users.full_name',
            )
            ->where(function($query) use ($keyword) {
                $query->where('users.full_name', 'like', "%$keyword%")
                    ->orWhere('orders.payment_method', 'like', "%$keyword%")
                    ->orWhere('orders.status', 'like', "%$keyword%");
            })
            ->where('users.role', 0)
            ->orderBy('orders.id')
            ->paginate($limit);
        return $data;
    }
    public function view($id)
    {
        $order = Order::query()->findOrFail($id);
        $data = OrderDetail::query()->where('order_id', $id)->get();
        return view('backend.order.view', compact('data', 'order'));
    }
}
