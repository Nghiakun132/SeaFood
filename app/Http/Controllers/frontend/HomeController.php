<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\import_product;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $productsLatest = products::orderBy('pro_id', 'desc')->take(8)->get();
        return view('frontend.home.index', compact('productsLatest'));
    }
    public function test()
    {
        $cp = DB::table('coupons')->where('cou_status',0)->inRandomOrder()->first();
        dd($cp);
    }
}
