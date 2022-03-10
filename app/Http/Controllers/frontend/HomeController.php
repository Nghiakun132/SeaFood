<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\import_product;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        //san pham moi nhat
        $productsLatest = products::orderBy('pro_id', 'desc')->take(8)->get();
        $products = products::orderBy('pro_name', 'desc')->take(8)->get();
        $product = DB::table('products')->get();
        //san pham ban chay nhat
        $product_sell = DB::table('products')
            ->rightJoin('order_details', 'products.pro_id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
            ->where('orders.order_status', '<>', 2)
            ->select(DB::raw('sum(order_details.product_quantity) as total'), 'product_id')
            ->groupBy('order_details.product_id')
            ->get();
        //covert object to array
        $product_sell = json_decode(json_encode($product_sell), true);
        $product_arr = json_decode(json_encode($product), true);
        $pro_sale_arr = [];
        for ($i = 0; $i < count($product_sell); $i++) {
            for ($j = 0; $j < count($product_arr); $j++) {
                if ($product_sell[$i]['product_id'] == $product_arr[$j]['pro_id']) {
                    $pro_sale_arr[] = array(
                        'pro_name' => $product_arr[$j]['pro_name'],
                        'product_sell' => $product_sell[$i]['total'],
                        'pro_qty' => $product_arr[$j]['pro_qty'],
                        'pro_id' => $product_arr[$j]['pro_id'],
                        'pro_avatar' => $product_arr[$j]['pro_avatar'],
                        'pro_slug' => $product_arr[$j]['pro_slug'],
                        'pro_sale' => $product_arr[$j]['pro_sale'],
                        'pro_price' => $product_arr[$j]['pro_price'],
                        'pro_unit' => $product_arr[$j]['pro_unit']
                    );
                }
            }
        }
        //sap xep giam dan
        for ($i = 0; $i < count($pro_sale_arr); $i++) {
            for ($j = $i + 1; $j < count($pro_sale_arr); $j++) {
                if ($pro_sale_arr[$i]['product_sell'] < $pro_sale_arr[$j]['product_sell']) {
                    $temp = $pro_sale_arr[$i];
                    $pro_sale_arr[$i] = $pro_sale_arr[$j];
                    $pro_sale_arr[$j] = $temp;
                }
            }
        }
        //san pham giam gia nhieu nhat
        $productsDiscount = products::orderBy('pro_sale', 'desc')->take(8)->get();
        //san pham duoc xem nhieu nhat
        $productsView = products::orderBy('pro_view', 'desc')->take(8)->get();

        $timestamp = DB::table('sales')->where('sale_status', 1)->first();
        $timestamp = $timestamp ? Carbon::parse($timestamp->time_end)->format('Y/m/d H:i:s') : null;
        $sales = DB::table('sales')
        ->join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
        ->join('products', 'sale_details.product_id', '=', 'products.pro_id')
        ->where('sale_status',1)
        ->get();
        return view('frontend.home.index', compact('productsLatest', 'productsDiscount', 'productsView', 'pro_sale_arr', 'products', 'sales','timestamp'));
    }
}
