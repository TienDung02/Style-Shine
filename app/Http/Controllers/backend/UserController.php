<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController
{
    public function index()
    {
        $totalCustomers = Customer::where('role', 0)->count();
        $data = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.username',
                'users.full_name',
                'users.email',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM orders as invoices2 WHERE invoices2.user_id = users.id) as last_purchase_date')
            )
            ->where('users.role', 0)
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.id')
            ->paginate(5);
        return view('backend.user.index', compact("totalCustomers", "data"));
    }

    public function getLimit (Request $request) {
        $data = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.username',
                'users.full_name',
                'users.email',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM orders as invoices2 WHERE invoices2.user_id = users.id) as last_purchase_date')
            )
            ->where('users.role', 0)
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.id');
        $keyword = $request->keyword;

        $limit = $request->input('limit', 5);
        if ($keyword == null) {
            $data = $data->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        return view('backend.user.ajax.table', compact('data'));
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        if ($keyword == null) {
            $data = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.username',
                    'users.full_name',
                    'users.email',
                    DB::raw('SUM(order_details.quantity) as total_quantity'),
                    DB::raw('(SELECT MAX(invoices2.created_at) FROM orders as invoices2 WHERE invoices2.user_id = users.id) as last_purchase_date')
                )
                ->where('users.role', 0)
                ->groupBy('users.id', 'users.full_name')
                ->orderBy('users.id')
                ->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
//        dd($data);
        return view('backend.user.ajax.table', compact('data'));
    }
    public function result_search($keyword, $limit = 5)
    {
        $data = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.username',
                'users.full_name',
                'users.email',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM orders as invoices2 WHERE invoices2.user_id = users.id) as last_purchase_date')
            )
            ->where(function($query) use ($keyword) {
                $query->where('users.username', 'like', "%$keyword%")
                    ->orWhere('users.full_name', 'like', "%$keyword%")
                    ->orWhere('users.email', 'like', "%$keyword%");
            })
            ->where('users.role', 0)
            ->groupBy('users.id', 'users.username', 'users.full_name', 'users.email') // cần group đủ cột select
            ->orderBy('users.id')
            ->paginate($limit);
        return $data;
    }
    public function view($id)
    {
        $user = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.username',
                'users.full_name',
                'users.email',
                'users.phone',
                'users.address',
                'users.avatar',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM orders as invoices2 WHERE invoices2.user_id = users.id) as last_purchase_date')
            )
            ->where('users.id', $id)
            ->groupBy('users.id', 'users.full_name')
            ->orderBy('users.id')
            ->first();
        return view('backend.user.profile',compact('user'));
    }
}
