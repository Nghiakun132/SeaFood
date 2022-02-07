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
            $products = products::where('pro_category_id', $cate->c_id)->paginate(12);
            return view('frontend.category.index', compact('products', 'cate'));
        } catch (\Throwable $th) {
            return redirect()->route('home');
        }
    }
    public function search(){

    }
}
