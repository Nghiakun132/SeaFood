<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function test(){
        $pro = DB::table('products')->where('pro_id', '=', 1)->first();
        return view('backend.products.test', compact('pro'));
    }
    public function test1(Request $request){
       DB::table('products')->where('pro_id',1)->update([
            'pro_description' => $request->content,
        ]);
        return redirect()->back();
    }
}
