<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
        return view('frontend.cart.index', compact('cart', 'total'));
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
    public function quickAddCart($pro_id)
    {
        $this->AuthLogin();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $productAdd = products::where('pro_slug',$pro_id)->first();
        $product = cart::where('cart_product_name', $productAdd->pro_name)->where('cart_user_id', Session::get('user')->id)->first();
        if ($product) {
            $product->cart_product_quantity = $product->cart_product_quantity + 1;
            $product->cart_product_total =  $product->cart_product_total + (1 * $product->cart_product_price);
            $product->save();
            return redirect()->route('cart')->with('success', 'Thêm sản phẩm thành công');
        } else {
            $cart = new cart();
            $cart->cart_id = substr(str_shuffle($permitted_chars), 0, 16);
            $cart->cart_user_id = Session::get('user')->id;
            $cart->cart_product_name = $productAdd->pro_name;
            $cart->cart_product_image = $productAdd->pro_avatar;
            $cart->cart_product_price = $productAdd->pro_price;
            $cart->cart_product_total = $productAdd->pro_price * 1;
            $cart->cart_product_quantity = 1;
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

    public function checkout()
    {
        $this->AuthLogin();
        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        if (Session::get('cou_value')) {
            $total = $total - (Session::get('cou_value') * $total);
        }
        return view('frontend.cart.checkout', compact('cart', 'total'));
    }
    public function postCoupon(Request $request)
    {
        $this->AuthLogin();
        $checkCoupon = DB::table('coupons')->where('cou_code', $request->coupon_code)->first();
        if ($checkCoupon) {
            $expired_date = $checkCoupon->cou_expired_date;
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            if ($checkCoupon->cou_status == 0) {
                return redirect()->back()->with('error', 'Mã giảm giá đã bị sử dụng');
            } elseif ($expired_date < $now) {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn');
            } else {
                Session::put('cou_code', $checkCoupon->cou_code);
                Session::put('cou_value', $checkCoupon->cou_value);
                return redirect()->back()->with('success', 'Mã giảm giá đã được áp dụng');
            }
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
        }
    }
    public function deleteCoupon()
    {
        $this->AuthLogin();
        if (Session::get('cou_value')) {
            Session::forget('cou_code');
            Session::forget('cou_value');
            return redirect()->back()->with('success', 'Mã giảm giá đã được hủy');
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
        }
    }
    public function postCheckout(Request $request)
    {
        $this->AuthLogin();
        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        $data = array();
        //check co ma giam gia ko?
        if (Session::get('cou_value')) {
            //them vo orders
            $data['user_id'] = Session::get('user')->id;
            $data['price_total'] = $total - (Session::get('cou_value') * $total);
            $data['order_code'] = Session::get('cou_code');
            $data['order_type'] = $request->payment_method;
            $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $order_id = DB::table('orders')->insertGetId($data);
            //them vo order_details
            foreach ($cart as $key => $value) {
                $data_detail = array();
                $data_detail['order_id'] = $order_id;
                $data_detail['product_name'] = $value->cart_product_name;
                $data_detail['product_price'] = $value->cart_product_price;
                $data_detail['product_quantity'] = $value->cart_product_quantity;
                DB::table('order_details')->insert($data_detail);
            }
            //giam so luong trong kho
            foreach ($cart as $key => $value) {
                $product = DB::table('products')->where('pro_name', $value->cart_product_name)->first();
                DB::table('products')->where('pro_id', $product->pro_id)
                    ->update(['pro_qty' => $product->pro_qty - $value->cart_product_quantity]);
            }
            //thong bao don hang moi
            DB::table('notifications')->insert([
                'type' => 'Đơn hàng mới',
                'role' => 1,
                'notification' => 'Có đơn hàng mới từ ' . Session::get('user')->name . ' với mã đơn hàng #' . $order_id,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
            //xoa gio hang
            DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();
            // xoa ma giam gia
            DB::table('coupons')->where('cou_code', Session::get('cou_code'))->update(['cou_status' => 0]);
            // xoa session
            Session::forget('cou_code');
            Session::forget('cou_value');
            return view('frontend.cart.success');
        } else {
            //them vo orders
            $data['user_id'] = Session::get('user')->id;
            $data['price_total'] = $total;
            $data['order_code'] = $request->order_code;
            $data['order_type'] = $request->payment_method;
            $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $order_id = DB::table('orders')->insertGetId($data);
            //them vo order_details
            foreach ($cart as $key => $value) {
                $data_detail = array();
                $data_detail['order_id'] = $order_id;
                $data_detail['product_name'] = $value->cart_product_name;
                $data_detail['product_price'] = $value->cart_product_price;
                $data_detail['product_quantity'] = $value->cart_product_quantity;
                DB::table('order_details')->insert($data_detail);
            }
            //giam so luong trong kho
            foreach ($cart as $key => $value) {
                $product = DB::table('products')->where('pro_name', $value->cart_product_name)->first();
                DB::table('products')->where('pro_id', $product->pro_id)
                    ->update(['pro_qty' => $product->pro_qty - $value->cart_product_quantity]);
            }
            //thong bao don hang moi
            DB::table('notifications')->insert([
                'type' => 'Đơn hàng mới',
                'notification' => 'Có đơn hàng mới từ ' . Session::get('user')->name . ' với mã đơn hàng #' . $order_id,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);

            //xoa gio hang
            DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();

            return view('frontend.cart.success');
        }
    }
}
