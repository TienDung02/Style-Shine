<?php

namespace App\Http\Controllers\backend;

use App\Models\Customer;

class UserController
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $data = Customer::query()->paginate(10);
        return view('backend.user.index', compact("totalCustomers", "data"));
    }
}
