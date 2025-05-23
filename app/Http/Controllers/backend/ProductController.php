<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;

class ProductController
{
    public function index()
    {
        $totalProducts = Product::count();
        $data = Product::query()->paginate(10);
        return view('backend.product.index', compact("totalProducts", "data"));
    }
}
