<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug)
    {
        try {
            $cate = categories::where('c_slug', $slug)->first();
            $products = products::where('pro_category_id', $cate->c_id)->where('pro_status', 0)->paginate(18);
            if (isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == 'moi-nhat') {
                    $products = products::where('pro_category_id', $cate->c_id)->where('pro_status', 0)->orderBy('pro_price', 'asc')->paginate(18);
                } elseif ($sort_by == 'gia-giam-dan') {
                    $products = products::where('pro_category_id', $cate->c_id)->where('pro_status', 0)->orderBy('pro_price', 'desc')->paginate(18);
                } elseif ($sort_by == 'gia-tang-dan') {
                    $products = products::where('pro_category_id', $cate->c_id)->where('pro_status', 0)->orderBy('pro_id', 'asc')->paginate(18);
                }
            }
            return view('frontend.category.index', compact('products', 'cate'));
        } catch (\Throwable $th) {
            return redirect()->route('home');
        }
    }
    public function search()
    {
        if (isset($_GET['search'])) {
            $keyword = $_GET['search'];
            $products = products::where('pro_name', 'like', '%' . $keyword . '%')->where('pro_status', 0)->paginate(18);
            return view('frontend.category.search', compact('products'));
        } else {
            return redirect()->route('home');
        }
    }
}
