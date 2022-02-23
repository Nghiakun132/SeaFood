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
        //san pham moi nhat
        $productsLatest = products::orderBy('pro_id', 'desc')->take(8)->get();
        $products = products::orderBy('pro_name', 'desc')->take(8)->get();
        //san pham ban chay nhat
        // $bestSeller = products::join('import_products', 'import_products.ip_product_name', '=', 'products.pro_name')
        //     ->select('import_products.ip_product_name', DB::raw('sum(import_products.ip_qty) as total'))
        //     ->groupBy('import_products.ip_product_name')
        //     ->orderBy('import_products.ip_product_name', 'desc')
        //     ->take(8)->get();
        $bestSeller= products::join('import_product_details', 'import_product_details.ipd_product_id', '=', 'products.pro_id')
            ->join('import_products', 'import_products.ip_id', '=', 'import_product_details.ipd_import_product_id')
            ->select('import_product_details.ipd_product_id', DB::raw('sum(import_product_details.ipd_quantity) as total'))
            ->groupBy('import_product_details.ipd_product_id')
            ->orderBy('total', 'desc')
            ->take(8)->get();
        $arr = $products->toArray();
        $arr2 = $bestSeller->toArray();
        foreach ($arr as $key => $value) {
            foreach ($arr2 as $key2 => $value2) {
                if ($value['pro_id'] == $value2['ipd_product_id']) {
                    $arr[$key]['total'] = $value2['total'];
                }
            }
        }
        //sap xep san pham ban chay nhat
        usort($arr, function ($a, $b) {
            return ($b['total'] - $b['pro_qty']) - ($a['total'] - $a['pro_qty']);
        });
        $productsBestSeller = array_slice($arr, 0, 8);
        //san pham giam gia nhieu nhat
        $productsDiscount = products::orderBy('pro_sale', 'desc')->take(8)->get();
        //san pham duoc xem nhieu nhat
        $productsView = products::orderBy('pro_view', 'desc')->take(8)->get();
        return view('frontend.home.index', compact('productsLatest','productsBestSeller','productsDiscount','productsView'));
    }
    public function test()
    {
        $cp = DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first();
        dd($cp);
    }
}
