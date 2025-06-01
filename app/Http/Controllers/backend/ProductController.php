<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductController
{
    public function index()
    {
        $totalProducts = Product::count();
        $data = Product::query()->withSum('orderDetails as sold_quantity', 'quantity')->withCount('reviews')->withAvg('reviews', 'rating')->paginate(5);
        return view('backend.product.index', compact("totalProducts", "data"));
    }
    public function getLimit (Request $request) {
        $data = Product::query()->withSum('orderDetails as sold_quantity', 'quantity')->withCount('reviews')->withAvg('reviews', 'rating');
        $keyword = $request->keyword;

        $limit = $request->input('limit', 5);
        if ($keyword == null) {
            $data = $data->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        $totalProducts = Product::count();
        return view('backend.product.ajax.table', compact('data', 'totalProducts'));
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit;
        if ($keyword == null) {
            $data = Product::query()->withSum('orderDetails as sold_quantity', 'quantity')->withCount('reviews')->withAvg('reviews', 'rating')->paginate($limit);
        }else{
            $data = $this->result_search($keyword, $limit);
        }
        $totalProducts = Product::count();
        return view('backend.product.ajax.table', compact('data', 'totalProducts'));
    }
    public function result_search($keyword, $limit = 5)
    {


        $ids = Product::search($keyword)->take(1000)->get()->pluck('id');

        $rawResults = Product::whereIn('id', $ids)
            ->withSum('orderDetails as sold_quantity', 'quantity')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();

        $filtered = $rawResults->filter(function ($product) use ($keyword) {
            return str_contains(strtolower($product->name), strtolower($keyword));
        });

        $page = request()->get('page', 1);
        $perPage = $limit;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $filtered->forPage($page, $perPage),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginated;

    }
    public function add()
    {
        $product = '';
        $brands = Brand::query()->get();
        $categories = Category::query()->get();
        return view('backend.product.add',compact('brands', 'product', 'categories'));
    }
    public function view($id)
    {
        $customersWhoBoughtCount = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('order_details.product_id', $id)
            ->distinct('orders.user_id')
            ->count('orders.user_id');
        $customersWhoReviewedCount = DB::table('reviews')
            ->where('product_id', $id)
            ->distinct('user_id')
            ->count('user_id');
        $percentageReviewed = 0;
        if ($customersWhoBoughtCount > 0) {
            $percentageReviewed = ($customersWhoReviewedCount / $customersWhoBoughtCount) * 100;
        }

        $product = Product::findOrFail($id);
        $brands = Brand::query()->get();
        $categories = Category::query()->get();
        $product_image = ProductImage::where('product_id', $id)
            ->where('is_primary', true)
            ->first();
        return view('backend.product.view',compact('brands', 'product', 'categories', 'product_image', 'percentageReviewed'));
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::query()->get();
        $categories = Category::query()->get();
        $product_image = ProductImage::where('product_id', $id)
            ->where('is_primary', true)
            ->first();
        return view('backend.product.add',compact('brands', 'product', 'categories', 'product_image'));
    }

    public function store(Request $request)
    {

        $insert_product = new Product();
        $insert_product->name = $request->input('name');
        $insert_product->brand_id = $request->input('brand') ?? ' ';
        $insert_product->category_id = $request->input('category') ?? ' ';
        $insert_product->price = $request->input('price') ?? ' ';
        $insert_product->quantity = $request->input('quantity') ?? ' ';
        $insert_product->description = $request->input('desc') ?? ' ';

        $product_image = $request->file('image');

        if ($product_image){
            $path_logo = $product_image->store('uploads/product/images', 'public');

            $url_logo = asset('storage/' . $path_logo);
            $product_image_url = $url_logo;
        }else{
            $product_image_url = $request->input('avatar_old');
        }

        if ($insert_product->save()) {
            $insert_product->searchable();
            if ($product_image_url) {


                DB::table('product_images')->insert([
                    'image_url' => $product_image_url,
                    'is_primary' => true,
                    'product_id' => $insert_product->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Session::put('alert_2', [
                'alert_type' => 'success',
                'alert_title' => 'Added product successfully!',
                'alert_reload' => 'false',
            ]);
            return redirect()->route('admin.product');
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
        $product = Product::findOrFail($id);

        if ($request->filled('name')) $product->name = $request->input('name');
        if ($request->has('brand')) $product->brand_id = $request->input('brand');
        if ($request->has('category')) $product->category_id = $request->input('category');
        if ($request->has('price')) $product->price = $request->input('price');
        if ($request->has('quantity')) $product->quantity = $request->input('quantity');
        if ($request->has('desc')) $product->description = $request->input('desc');

        if ($product->save()) {
            $product->searchable();
            $currentPrimaryImage = ProductImage::where('product_id', $product->id)
                ->where('is_primary', true)
                ->first();

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if ($currentPrimaryImage && $currentPrimaryImage->image_url) {
                    $pathInStorage = Str::after($currentPrimaryImage->image_url, '/storage/');

                    if (Storage::disk('public')->exists($pathInStorage)) {
                        Storage::disk('public')->delete($pathInStorage);
                    }

                    $currentPrimaryImage->delete();
                }

                $path = $file->store('uploads/product/images', 'public');
                $publicUrl = Storage::url($path);

                DB::table('product_images')
                    ->where('product_id', $id)
                    ->update(['is_primary' => 0]);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $publicUrl,
                    'is_primary' => true,
                ]);

            } else {
                $oldImage = $request->input('avatar_old');
                if (empty($oldImage) && $currentPrimaryImage) {
                    $pathInStorage = Str::after($currentPrimaryImage->image_url, '/storage/');

                    if (Storage::disk('public')->exists($pathInStorage)) {
                        Storage::disk('public')->delete($pathInStorage);
                    }

                    $currentPrimaryImage->delete();
                }
            }

            Session::put('alert_2', [
                'alert_type' => 'success',
                'alert_title' => 'Updated product successfully!',
                'alert_reload' => 'false',
            ]);

            return redirect()->route('admin.product');
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
        $product = Product::find($id);
        if (!$product) {
            Session::put('alert_2', [
                'alert_type' => 'error',
                'alert_title' => 'Product not found.',
                'alert_reload' => 'false',
            ]);
            return redirect()->back();
        }
        if ($product->delete()) {
            $product->searchable();
            Session::put('alert_2', [
                'alert_type' => 'success',
                'alert_title' => 'Deleted product successfully!',
                'alert_reload' => 'true',
            ]);
            return redirect()->back();
        } else {
            Session::put('alert_2', [
                'alert_type' => 'error',
                'alert_title' => 'There was an error deleting the product!',
                'alert_reload' => 'false',
            ]);
            return redirect()->back();
        }
    }


}
