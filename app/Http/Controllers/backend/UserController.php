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
        $totalCustomers = Customer::count();
        $data = DB::table('invoice_detail')
            ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                'customer.id',
                'customer.username',
                'customer.cus_name',
                'customer.email',
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM invoice as invoices2 WHERE invoice.username = customer.username) as last_purchase_date')
            )
            ->groupBy('customer.username', 'customer.cus_name')
            ->paginate(5);
        return view('backend.user.index', compact("totalCustomers", "data"));
    }

    public function getLimit (Request $request) {
        $data = DB::table('invoice_detail')
            ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                'customer.id',
                'customer.username',
                'customer.cus_name',
                'customer.email',
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM invoice as invoices2 WHERE invoice.username = customer.username) as last_purchase_date')
            )
            ->groupBy('customer.username');
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
        $limit = $request->limit ?? 5;
        if ($keyword == null) {
            $data = DB::table('invoice_detail')
                ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
                ->join('customer', 'invoice.username', '=', 'customer.username')
                ->select(
                    'customer.id',
                    'customer.username',
                    'customer.cus_name',
                    'customer.email',
                    DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                    DB::raw('(SELECT MAX(invoices2.created_at) FROM invoice as invoices2 WHERE invoice.username = customer.username) as last_purchase_date')
                )
                ->groupBy('customer.username')
                ->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
//        dd($data);
        return view('backend.user.ajax.table', compact('data'));
    }
    public function result_search($keyword, $limit = 5)
    {
        $data = DB::table('invoice_detail')
            ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                DB::raw('MAX(customer.id) as id'),
                'customer.username',
                DB::raw('MAX(customer.cus_name) as cus_name'),
                DB::raw('MAX(customer.email) as email'),
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('MAX(invoice.created_at) as last_purchase_date')
            )
            ->where(function($query) use ($keyword) {
                $query->where('customer.username', 'like', "%$keyword%")
                    ->orWhere('customer.cus_name', 'like', "%$keyword%")
                    ->orWhere('customer.email', 'like', "%$keyword%");
            })
            ->groupBy('customer.username')
            ->paginate($limit);
        return $data;
    }
    public function view($id)
    {
        $user = DB::table('invoice_detail')
            ->join('invoice', 'invoice_detail.invoice_id', '=', 'invoice.id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->select(
                'customer.id',
                'customer.username',
                'customer.cus_name',
                'customer.email',
                'customer.phone_number',
                'customer.address',
                'customer.avatar_url',
                DB::raw('SUM(invoice_detail.quantity) as total_quantity'),
                DB::raw('(SELECT MAX(invoices2.created_at) FROM invoice as invoices2 WHERE invoices2.username = customer.username) as last_purchase_date')
            )
            ->where('customer.id', $id)
            ->groupBy(
                'customer.id',
                'customer.username',
                'customer.cus_name',
                'customer.email',
                'customer.phone_number',
                'customer.address',
                'customer.avatar_url'
            )
            ->first();
        return view('backend.user.profile',compact('user'));
    }
}
