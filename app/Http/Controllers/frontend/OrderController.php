<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
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
        $this->AuthLogin();
        $orders = DB::table('orders')->orderBy('order_id', 'desc')->where('user_id', Session::get('user')->id)->get();
        return view('frontend.order.index', compact('orders'));
    }
    public function detail($id)
    {
        $this->AuthLogin();
        $order_detail = DB::table('order_details')->where('order_id', $id)->get();
        return view('frontend.order.detail', compact('order_detail'));
    }
    public function cancel($id)
    {
        $this->AuthLogin();
        $order = DB::table('orders')->where('order_id', $id)->first();
        return view('frontend.order.cancel', compact('order'));
    }
    public function postCancel(Request $request)
    {
        $this->AuthLogin();
        $reason = $request->reason;
        $order_id = $request->order_id;
        DB::table('orders')->where('order_id', $order_id)->update(['order_status' => 2]);
        DB::table('order_cancel')->insert(['order_id' => $order_id, 'reason' => $reason, 'created_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
        return redirect()->route('order');
    }
}
