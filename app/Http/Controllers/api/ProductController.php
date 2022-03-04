<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $sanphambanchaynhat = DB::table('order_details')
            ->rightJoin('products', 'order_details.product_id', '=', 'products.pro_id')
            ->select( DB::raw('SUM(order_details.product_quantity) as soluong'),DB::raw('sum(products.pro_qty) as soluong2') , DB::raw('products.pro_name as tensanpham'))
            ->groupBy('products.pro_name')
            ->orderBy('soluong', 'desc')
            ->get();
        $arr = json_decode(json_encode($sanphambanchaynhat), true);
        foreach ($arr as $key => $value) {
            $arr[$key]['soluong'] = (int)$value['soluong'];
            $arr[$key]['soluong2'] = (int)$value['soluong2'];
        }
        return response()->json([
            'san pham' => $arr,
        ]);
    }
    public function getQuantity(){
        $qty = $this->getQuantityByDays(3);
        return response()->json([
            'qty' => $qty,
        ]);
    }
    // thong ke so luong san pham ban theo ngay
    static function getQuantityByDays($days)
    {
        $qty = DB::table('order_details')
->join('orders', 'orders.order_id', '=', 'order_details.order_id')
        ->rightJoin('products', 'order_details.product_id', '=', 'products.pro_id')
            ->select( DB::raw('SUM(order_details.product_quantity) as soluong'),DB::raw('sum(products.pro_qty) as soluong2') , DB::raw('products.pro_name as tensanpham'))
            ->where('orders.order_status', '<>', 2)
            ->whereDay('order_details.created_at', '=', $days)
            ->groupBy('products.pro_name')
            ->orderBy('soluong', 'desc')
            ->get();
        $arr = json_decode(json_encode($qty), true);
        return $arr;
    }
}
