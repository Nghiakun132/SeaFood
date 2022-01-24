<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CartController extends Controller
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
        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        return view('frontend.cart.index', compact('cart','total'));
    }
    public function addCart(Request $request)
    {
        $this->AuthLogin();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $product = cart::where('cart_product_name', $request->pro_name)->where('cart_user_id', Session::get('user')->id)->first();
        if ($product) {
            $product->cart_product_quantity = $product->cart_product_quantity + $request->product_quatity;
            $product->cart_product_total =  $product->cart_product_total + ($request->product_quatity * $product->cart_product_price);
            $product->save();
            return redirect()->route('cart')->with('success', 'Thêm sản phẩm thành công');
        } else {
            $cart = new cart();
            $cart->cart_id = substr(str_shuffle($permitted_chars), 0, 16);
            $cart->cart_user_id = Session::get('user')->id;
            $cart->cart_product_name = $request->pro_name;
            $cart->cart_product_image = $request->pro_avatar;
            $cart->cart_product_price = $request->pro_price;
            $cart->cart_product_total = $request->pro_price * $request->product_quatity;
            $cart->cart_product_quantity = $request->product_quatity;
            $cart->save();
            return redirect()->route('cart')->with('success', 'Thêm giỏ hàng thành công');
        }
    }
    public function updateCart(Request $request, $cart_id)
    {
        $this->AuthLogin();
        $cart = cart::where('cart_id', $cart_id)->first();
        $cart->cart_product_quantity = $request->product_quatity;
        $cart->cart_product_total = $request->product_quatity * $cart->cart_product_price;
        $cart->save();
        return redirect()->route('cart')->with('success', 'Cập nhật giỏ hàng thành công');
    }
    public function deleteCart($cart_id)
    {
        $this->AuthLogin();
        $cart = cart::where('cart_id', $cart_id)->first();
        $cart->delete();
        return redirect()->route('cart')->with('success', 'Xóa giỏ hàng thành công');
    }
    public function clearCart()
    {
        $this->AuthLogin();
        $cart = cart::where('cart_user_id', Session::get('user')->id)->delete();
        return redirect()->route('cart')->with('success', 'Xóa giỏ hàng thành công');
    }
}
