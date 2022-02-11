<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class OrderController extends Controller
{
    public function AuthLogin()
    {
        $admin = Session::get('admins');
        if ($admin) {
            return redirect()->route('home');
        } else {
            return redirect()->route('admin.login')->send();
        }
    }
    public function index()
    {
        $this->AuthLogin();
        $orders = DB::table('orders')->orderBy('order_id', 'desc')->get();
        return view('backend.orders.index', compact('orders'));
    }
    public function changeStatus($id)
    {
        $this->AuthLogin();
        $order = DB::table('orders')->where('order_id', $id)->first();
        if ($order->order_status == 0) {
            DB::table('orders')->where('order_id', $id)->update(['order_status' => 1]);
            DB::table('notifications')->insert(['notification' => 'Đơn hàng #' . $order->order_id . ' của bạn đã được xác nhận', 'role' => 0, 'user_id' => $order->user_id, 'type' => 'Xác nhận Đơn hàng', 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        } elseif ($order->order_status == 1) {
            DB::table('orders')->where('order_id', $id)->update(['order_status' => 3]);
            DB::table('notifications')->insert(['notification' => 'Đơn hàng #' . $order->order_id . ' của bạn đã được giao', 'role' => 0, 'user_id' => $order->user_id, 'type' => 'Xác nhận Đơn hàng', 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        }
        return redirect()->back();
    }
    public function destroy($id)
    {
        $this->AuthLogin();
        DB::table('orders')->where('order_id', $id)->delete();
        return redirect()->back();
    }
}
