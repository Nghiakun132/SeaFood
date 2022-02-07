<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
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
    public function index(){
        $this->AuthLogin();
        $orders = DB::table('orders')->orderBy('order_id', 'desc')->get();
        return view('backend.orders.index', compact('orders'));
    }
}
