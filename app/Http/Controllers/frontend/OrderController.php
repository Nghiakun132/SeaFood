<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class OrderController extends Controller
{
    public function AuthLogin()
    {
        $user = Session::get('user');
        if ($user) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->send();
        }
    }
    public function index()
    {
        // $this->AuthLogin();
        $orders = DB::table('orders')->orderBy('order_id', 'desc')->where('user_id', Session::get('user')->id)->get();
        $ordersWait = DB::table('orders')->orderBy('order_id', 'desc')->where('user_id', Session::get('user')->id)->where('order_status', '0')->get();
        $ordersConfirmed = DB::table('orders')->orderBy('order_id', 'desc')->where('user_id', Session::get('user')->id)->where('order_status', '1')->get();
        $ordersDelivered = DB::table('orders')->orderBy('order_id', 'desc')->where('user_id', Session::get('user')->id)->where('order_status', '3')->get();
        $ordersCancel = DB::table('orders')->orderBy('order_id', 'desc')->where('user_id', Session::get('user')->id)->where('order_status', '2')->get();
        return view('frontend.order.index', compact('orders', 'ordersWait', 'ordersConfirmed', 'ordersDelivered', 'ordersCancel'));
    }
    public function detail($id)
    {
        // $this->AuthLogin();
        $order_detail = DB::table('order_details')
        ->join('products', 'products.pro_id', '=', 'order_details.product_id')
        ->where('order_id', $id)->get();
        return view('frontend.order.detail', compact('order_detail'));
    }
    public function cancel($id)
    {
        // $this->AuthLogin();
        $order = DB::table('orders')->where('order_id', $id)->first();
        return view('frontend.order.cancel', compact('order'));
    }
    public function postCancel(Request $request)
    {
        // $this->AuthLogin();
        $reason = $request->reason;
        $order_id = $request->order_id;
        $product = DB::table('order_details')->where('order_id', $order_id)->get();
        foreach ($product as $key => $value) {
            $product_id = $value->product_id;
            $product = products::where('pro_id', $product_id)->first();
            $product->pro_qty = $product->pro_qty + $value->product_quantity;
            $product->save();
        }
        DB::table('orders')->where('order_id', $order_id)->update(['order_status' => 2]);
        DB::table('order_cancel')->insert(['order_id' => $order_id, 'reason' => $reason, 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        DB::table('notifications')->insert(['notification' => 'Đơn hàng #' . $order_id . ' của bạn đã bị hủy', 'user_id' => Session::get('user')->id, 'role' => 0, 'type' => 'Hủy Đơn hàng', 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        return redirect()->route('order');
    }
}
