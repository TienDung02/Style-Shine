<?php

namespace App\Http\Controllers\backend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ProductImage;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use function PHPUnit\Framework\isEmpty;

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
        $escapedKeyword = addcslashes($keyword, '%_');
        $products = Product::where('name_product', 'like', '%' . $escapedKeyword . '%')
            ->withSum('orderDetails as sold_quantity', 'quantity')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate($limit);

        return $products;

    }
    public function add()
    {
        $product = '';
        $categories = Category::query()->get();
//        dd($categories);
        return view('backend.product.add',compact( 'product', 'categories'));
    }
    public function view($id)
    {
        $customersWhoBoughtCount = DB::table('product')
            ->join('invoice_detail', 'product.ID_PRODUCT', '=', 'invoice_detail.product_id')
            ->join('invoice', 'invoice.id', '=', 'invoice_detail.invoice_id')
            ->join('customer', 'invoice.username', '=', 'customer.username')
            ->where('product.ID_PRODUCT', $id)
            ->distinct('customer.username')
            ->count('customer.username');
        $quantitySold = Product::query()
            ->withSum('orderDetails as sold_quantity', 'quantity')
            ->where('ID_PRODUCT', $id)
            ->first()?->sold_quantity ?? 0;
        $customersWhoReviewedCount = DB::table('review')
            ->where('ID_PRODUCT', $id)
            ->distinct('username')
            ->count('username');
        $percentageReviewed = 0;
        if ($customersWhoBoughtCount > 0) {
            $percentageReviewed = ($customersWhoReviewedCount / $customersWhoBoughtCount) * 100;
        }
        $averageRating = DB::table('review')
            ->where('ID_PRODUCT', $id)
            ->avg('RATING');
        $countRating = DB::table('review')
            ->where('ID_PRODUCT', $id)->count('review.id');
        $ratingCounts = DB::table('review')
            ->select('RATING', DB::raw('COUNT(*) as total'))
            ->where('ID_PRODUCT', $id)
            ->groupBy('RATING')
            ->orderByDesc('RATING')
            ->get();
        $ratings = collect([5, 4, 3, 2, 1])->map(function ($star) use ($ratingCounts) {
            $found = $ratingCounts->firstWhere('RATING', $star);
            return (object)[
                'RATING' => $star,
                'total' => $found ? $found->total : 0
            ];
        });
        $reviews = DB::table('review')
            ->select('review.*', 'customer.*', 'product.NAME_PRODUCT')
            ->leftJoin('customer', 'review.username', '=', 'customer.username')
            ->leftJoin('product', 'product.id_product', '=', 'review.id_product')
            ->where('review.id_product', '=', $id)
            ->orderBy('review.create_at', 'desc')
            ->get();

//        dd($reviews);
        if ($reviews->isEmpty()) {
            Session::put('alert_', [
                'alert_type' => 'error',
                'alert_title' => 'This product has no review',
                'alert_text' => '',
                'alert_reload' => 'false',
            ]);
            return back();
        }

        $product = DB::table('product')
            ->select('product.*',
                'category.name as category_name',
            )
            ->leftJoin('category', 'product.id_category', '=', 'category.id')
            ->where('product.ID_PRODUCT', $id)
            ->first();
        $categories = Category::query()->get();
        return view('backend.product.view',compact( 'product', 'categories', 'quantitySold','percentageReviewed', 'averageRating', 'countRating', 'ratings', 'reviews'));
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
        $insert_product->name_product = $request->input('name');
        $insert_product->brand = $request->input('brand') ?? ' ';
        $insert_product->id_category = $request->input('category') ?? ' ';
        $insert_product->price = $request->input('price') ?? ' ';
        $insert_product->quality = $request->input('quantity') ?? ' ';
        $insert_product->description = $request->input('desc') ?? ' ';

        $product_image = $request->file('image');

        if ($product_image) {
            $ext = $product_image->getClientOriginalExtension();
            $fileName = 'product_' . uniqid() . '.' . $ext;
            $destinationPath = public_path('api/uploads/products');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $product_image->move($destinationPath, $fileName);
            $insert_product->image_url = url('api/uploads/products/' . $fileName);
        } else {
            $insert_product->image_url = $request->input('avatar_old');
        }

        if ($insert_product->save()) {
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
        if ($request->filled('name')) $product->NAME_PRODUCT = $request->input('name');
        if ($request->has('brand')) $product->BRAND = $request->input('brand');
        if ($request->has('category')) $product->ID_CATEGORY = $request->input('category');
        if ($request->has('price')) $product->PRICE = $request->input('price');
        if ($request->has('quantity')) $product->QUALITY = $request->input('quantity');
        if ($request->has('desc')) $product->DESCRIPTION = $request->input('desc');

//        dd($product->isDirty(), $product->getDirty());
//        dd($product);

        if ($product->save()) {
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
    public function exportCSV()
    {
        $products = Product::query()->withSum('orderDetails as sold_quantity', 'quantity')->withCount('reviews')->withAvg('reviews', 'rating')->get();

        $filename = 'products_' . date('Ymd_His') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['ID', 'Name', 'Price (VND)', 'Quantity', 'Description', 'Image_url', 'Brand', 'Quantity Sold', 'reviews_count', 'reviews_avg_rating']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->ID_PRODUCT,
                    $product->NAME_PRODUCT,
                    $product->PRICE,
                    $product->QUALITY,
                    $product->DESCRIPTION,
                    $product->IMAGE_URL,
                    $product->BRAND,
                    $product->sold_quantity,
                    $product->reviews_count,
                    round($product->reviews_avg_rating, 1)
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }


}
