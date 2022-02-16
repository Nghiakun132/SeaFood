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
use Srmklive\PayPal\Services\PayPal as PayPalClient;


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
    //them vao gio hang
    public function addCart(Request $request)
    {
        $this->AuthLogin();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $product = cart::where('cart_product_name', $request->pro_name)->where('cart_user_id', Session::get('user')->id)->first();
        //ktra co ton tai chua ?
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
    //them nhanh 1 sp vao gio hang
    public function quickAddCart($pro_id)
    {
        $this->AuthLogin();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $productAdd = products::where('pro_slug', $pro_id)->first();
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
    //cap nhap gio hang
    public function updateCart(Request $request, $cart_id)
    {
        $this->AuthLogin();
        $cart = cart::where('cart_id', $cart_id)->first();
        $cart->cart_product_quantity = $request->product_quatity;
        $cart->cart_product_total = $request->product_quatity * $cart->cart_product_price;
        $cart->save();
        return redirect()->route('cart')->with('success', 'Cập nhật giỏ hàng thành công');
    }
    //xoa 1 sp khoi gio hang
    public function deleteCart($cart_id)
    {
        $this->AuthLogin();
        $cart = cart::where('cart_id', $cart_id)->first();
        $cart->delete();
        return redirect()->route('cart')->with('success', 'Xóa giỏ hàng thành công');
    }
    //xoa toan bo gio hang
    public function clearCart()
    {
        $this->AuthLogin();
        $cart = cart::where('cart_user_id', Session::get('user')->id)->delete();
        return redirect()->route('cart')->with('success', 'Xóa giỏ hàng thành công');
    }


    // trang thanh toan
    public function checkout()
    {
        $this->AuthLogin();
        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        if (Session::get('cou_value')) {
            $total = $total - (Session::get('cou_value') * $total);
        }
        $address = DB::table('address')->where('user_id', Session::get('user')->id)->get();
        return view('frontend.cart.checkout', compact('cart', 'total', 'address'));
    }

    // them voucher
    public function postCoupon(Request $request)
    {
        $this->AuthLogin();
        $checkCoupon = DB::table('coupons')->where('cou_code', $request->coupon_code)->first();
        $checkCouponUsed = DB::table('coupons_user')->where('code', $request->coupon_code)->where('user_id', Session::get('user')->id)->where('status', 1)->first();
        //ktra cac dk cua voucher
        if ($checkCoupon) {
            $expired_date = $checkCoupon->cou_expired_date;
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            if ($checkCouponUsed) {
                return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi');
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
    //xoa voicher
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
    //ham chuyen tien tu VND sang USD de thanh toan paypal
    static function getMoney($type)
    {
        $link = "http://api.exchangeratesapi.io/v1/latest?access_key=aa5b1ceed726ddb9fdecf80d6d3b6306&format=1";
        $json = file_get_contents($link);
        $data = json_decode($json, true);
        $arr = array();

        foreach ($data['rates'] as $key => $value) {
            $arr[$key] = $value;
        }
        return $arr[$type];
    }
    // thanh toan
    public function postCheckout(Request $request)
    {
        $this->AuthLogin();
        DB::table('address')
            ->where('address', $request->address_user)
            ->where('user_id', Session::get('user')->id)->update([
                'isDefault' => 1
            ]);

        DB::table('address')
            ->where('address', '<>', $request->address_user)
            ->where('user_id', Session::get('user')->id)->update([
                'isDefault' => 0
            ]);

        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        $value = floor($total / ($this->getMoney("VND") / $this->getMoney("USD")));
        if ($request->payment_method == 'Paypal') {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('successTransaction'),
                    "cancel_url" => route('cancelTransaction'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $value,
                        ]
                    ]
                ]
            ]);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()
                    ->route('checkout')
                    ->with('error', 'Something went wrong.');
            } else {
                return redirect()
                    ->route('checkout')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } else {
            $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            $data = array();
            //check co ma giam gia ko?
            if (Session::get('cou_value')) {
                //them vo orders
                $data['user_id'] = Session::get('user')->id;
                $data['price_total'] = $total - (Session::get('cou_value') * $total);
                $data['order_code'] = Session::get('cou_code');
                $data['address'] = $request->address_user;
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
                DB::table('coupons')->where('cou_code', Session::get('cou_code'))
                    ->update(['cou_number' => DB::table('coupons')
                        ->where('cou_code', Session::get('cou_code'))->first()->cou_number - 1]);
                DB::table('coupons_user')->where('code', Session::get('cou_code'))->where('user_id', Session::get('user')->id)->update([
                    'status' => 1,
                ]);
                if (($total - (Session::get('cou_value') * $total))  >= 1000000) {
                    DB::table('notifications')->insert([
                        'type' => 'Mã khuyến mãi',
                        'role' => 0,
                        'user_id' => Session::get('user')->id,
                        'notification' => 'Bạn đã được nhận mã giảm giá',
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
                    DB::table('coupons_user')
                        ->where('code', Session::get('cou_code'))
                        ->where('user_id', Session::get('user')->id)
                        ->insert([
                            'user_id' => Session::get('user')->id,
                            'code' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_code,
                            'status' => 0,
                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                        ]);
                }
                // xoa session
                Session::forget('cou_code');
                Session::forget('cou_value');
                return view('frontend.cart.success');
            } else {
                //them vo orders
                $data['user_id'] = Session::get('user')->id;
                $data['price_total'] = $total;
                $data['order_code'] = $request->order_code;
                $data['address'] = $request->address_user;
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
                if ($total  >= 1000000) {
                    DB::table('notifications')->insert([
                        'type' => 'Mã khuyến mãi',
                        'role' => 0,
                        'user_id' => Session::get('user')->id,
                        'notification' => 'Bạn đã được nhận mã giảm giá cho mọi đơn hàng khi mua hàng trên 1.000.000đ',
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
                    DB::table('coupons_user')
                        ->insert([
                            'user_id' => Session::get('user')->id,
                            'code' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_code,
                            'status' => 0,
                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                        ]);
                }
                //xoa gio hang
                DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();
                return view('frontend.cart.success');
            }
        }
    }
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            $data = array();
            //check co ma giam gia ko?
            if (Session::get('cou_value')) {
                //them vo orders
                $data['user_id'] = Session::get('user')->id;
                $data['price_total'] = $total - (Session::get('cou_value') * $total);
                $data['order_code'] = Session::get('cou_code');
                $data['address'] = DB::table('address')->where('user_id', Session::get('user')->id)->where('isDe');
                $data['order_type'] = "Paypal";
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
                DB::table('coupons')->where('cou_code', Session::get('cou_code'))
                    ->update(['cou_number' => DB::table('coupons')
                        ->where('cou_code', Session::get('cou_code'))->first()->cou_number - 1]);
                DB::table('coupons_user')->where('code', Session::get('cou_code'))->where('user_id', Session::get('user')->id)->update([
                    'status' => 1,
                ]);
                if (($total - (Session::get('cou_value') * $total))  >= 1000000) {
                    DB::table('notifications')->insert([
                        'type' => 'Mã khuyến mãi',
                        'role' => 0,
                        'user_id' => Session::get('user')->id,
                        'notification' => 'Bạn đã được nhận mã giảm giá',
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
                    DB::table('coupons_user')
                        ->where('code', Session::get('cou_code'))
                        ->where('user_id', Session::get('user')->id)
                        ->insert([
                            'user_id' => Session::get('user')->id,
                            'code' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_code,
                            'status' => 0,
                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                        ]);
                }
                // xoa session
                Session::forget('cou_code');
                Session::forget('cou_value');
                return view('frontend.cart.success');
            } else {
                //them vo orders
                $data['user_id'] = Session::get('user')->id;
                $data['price_total'] = $total;
                $data['order_code'] = $request->order_code;
                $data['address'] = DB::table('address')->where('user_id', Session::get('user')->id)->where('isDefault', 1)->first()->address;
                $data['order_type'] = "Paypal";
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
                    'role' => 1,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                if ($total  >= 1000000) {
                    DB::table('notifications')->insert([
                        'type' => 'Mã khuyến mãi',
                        'role' => 0,
                        'user_id' => Session::get('user')->id,
                        'notification' => 'Bạn đã được nhận mã giảm giá cho mọi đơn hàng khi mua hàng trên 1.000.000đ',
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
                    DB::table('coupons_user')
                        ->insert([
                            'user_id' => Session::get('user')->id,
                            'code' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_code,
                            'status' => 0,
                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                        ]);
                }
                //xoa gio hang
                DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();

                return view('frontend.cart.success');
            }
            return redirect()
                ->view('frontend.cart.success');
        } else {
            return redirect()
                ->route('cart')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('cart')
            ->with('error', $response['message'] ?? 'Ban da huy giao dich.');
    }
}
