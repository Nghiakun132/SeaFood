<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\image_products;
use App\Models\products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug){
        $product = products::where('pro_slug', $slug)->first();
        $images = image_products::where('img_product_id', $product->pro_id)->get();
        return view('frontend.detail.index', compact('product', 'images'));
    }
}
