<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryController
{
    public function index()
    {
        $totalCategories = Category::count();
        $data = Category::with(['parent', 'products'])->paginate(5);
        $all = Category::query()->get();
        return view('backend.category.index', compact("totalCategories", "data", "all"));
    }
    public function getLimit (Request $request) {
        $data = Category::with('products');
        $keyword = $request->keyword;

        $limit = $request->input('limit', 5);
        if ($keyword == null) {
            $data = $data->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        return view('backend.category.ajax.table', compact('data'));
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        if ($keyword == null) {
            $data = Category::query()->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
//        dd($data);
        return view('backend.category.ajax.table', compact('data'));
    }
    public function result_search($keyword, $limit = 5)
    {
        $results = Category::where('name', 'like', '%' . $keyword . '%')
            ->whereNull('deleted_at') // nếu bạn dùng soft delete
            ->take(1000)
            ->get();

        $page = request()->get('page', 1);
        $perPage = $limit;

        $data = new \Illuminate\Pagination\LengthAwarePaginator(
            $results->forPage($page, $perPage),
            $results->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $data;
    }
    public function add()
    {
        $product = '';
        $brands = Brand::query()->get();
        $categories = Category::query()->get();
        return view('backend.category.add',compact('brands', 'product', 'categories'));
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::query()->get();
        $categories = Category::query()->get();
        $product_image = ProductImage::where('product_id', $id)
            ->where('is_primary', true)
            ->first();

        return view('backend.category.add',compact('brands', 'product', 'categories', 'product_image'));
    }

    public function store(Request $request)
    {

        $insert_category = new Category();
        $insert_category->name = $request->input('name');
        $insert_category->parent_id = $request->input('parent_id') ?? ' ';



        if ($insert_category->save()) {
            $insert_category->searchable();
            Session::put('alert_2', [
                'alert_type' => 'success',
                'alert_title' => 'Added category successfully!',
                'alert_reload' => 'false',
            ]);
            return redirect()->route('admin.category');
        } else {
            Session::put('alert_', [
                'alert_type' => 'error',
                'alert_title' => 'Add fail',
                'alert_text' => 'Something went wrong, please try again later!',
                'alert_reload' => 'false',
            ]);
            return back();
        }
    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if ($request->filled('name')) $category->name = $request->input('name');
        if ($request->has('parent_id')) $category->parent_id = $request->input('parent_id');

        if ($category->save()) {
            $category->searchable();
            Session::put('alert_2', [
                'alert_type' => 'success',
                'alert_title' => 'Updated category successfully!',
                'alert_reload' => 'false',
            ]);
            return redirect()->route('admin.category');
        } else {
            Session::put('alert_', [
                'alert_type' => 'error',
                'alert_title' => 'Update failed',
                'alert_text' => 'Something went wrong, please try again later!',
                'alert_reload' => 'false',
            ]);
            return back();
        }
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            Session::put('alert_2', [
                'alert_type' => 'error',
                'alert_title' => 'Category not found.',
                'alert_reload' => 'false',
            ]);
            return redirect()->back();
        }
        if ($category->delete()) {
            $category->searchable();
            Session::put('alert_2', [
                'alert_type' => 'success',
                'alert_title' => 'Deleted category successfully!',
                'alert_reload' => 'true',
            ]);
            return redirect()->back();
        } else {
            Session::put('alert_2', [
                'alert_type' => 'error',
                'alert_title' => 'There was an error deleting the category!',
                'alert_reload' => 'false',
            ]);
            return redirect()->back();
        }
    }
}
