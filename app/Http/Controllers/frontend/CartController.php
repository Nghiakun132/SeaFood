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
        // $this->AuthLogin();
        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)
            ->join('products', 'products.pro_id', '=', 'cart.cart_product_id')
            ->get();
        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        $countCart = count($cart);
        $mostView = products::orderBy('pro_view', 'desc')->take(6)->get();
        return view('frontend.cart.index', compact('cart', 'total', 'countCart', 'mostView'));
    }
    //them vao gio hang
    public function addCart(Request $request)
    {
        try {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $qty = products::where('pro_id', $request->pro_id)->first()->pro_qty;
            $product = cart::where('cart_product_id', $request->pro_id)->where('cart_user_id', Session::get('user')->id)->first();
            //ktra co ton tai chua ?
            if ($request->qty > $qty) {
                return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ');
            } else {
                if ($product) {
                    $product->cart_product_quantity = $product->cart_product_quantity + $request->product_quatity;
                    $product->cart_product_total =  $product->cart_product_total + ($request->product_quatity * $product->cart_product_price);
                    $product->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $product->save();
                    DB::table('products')->where('pro_id', $request->pro_id)->update([
                        'pro_qty' => DB::table('products')->where('pro_id', $request->pro_id)->first()->pro_qty - $request->product_quatity,
                    ]);
                    return redirect()->route('cart')->with('success', 'Thêm sản phẩm thành công');
                } else {
                    $cart = new cart();
                    $cart->cart_id = substr(str_shuffle($permitted_chars), 0, 16);
                    $cart->cart_user_id = Session::get('user')->id;
                    $cart->cart_product_id = $request->pro_id;
                    $cart->cart_product_image = $request->pro_avatar;
                    $cart->cart_product_price = $request->pro_price;
                    $cart->cart_product_total = $request->pro_price * $request->product_quatity;
                    $cart->cart_product_quantity = $request->product_quatity;
                    $cart->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                    $cart->save();
                    return redirect()->route('cart')->with('success', 'Thêm giỏ hàng thành công');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm giỏ hàng thất bại ! Vui lòng thử lại');
        }
    }
    //them nhanh 1 sp vao gio hang
    public function quickAddCart($pro_id)
    {
        // $this->AuthLogin();
        try {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $productAdd = products::where('pro_slug', $pro_id)->first();
            $product = cart::where('cart_product_id', $productAdd->pro_id)->where('cart_user_id', Session::get('user')->id)->first();
            if ($product) {
                $product->cart_product_quantity = $product->cart_product_quantity + 1;
                $product->cart_product_total =  $product->cart_product_total + (1 * $product->cart_product_price);
                $product->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $product->save();
                return redirect()->route('cart')->with('success', 'Thêm sản phẩm thành công');
            } else {
                $cart = new cart();
                $cart->cart_id = substr(str_shuffle($permitted_chars), 0, 16);
                $cart->cart_user_id = Session::get('user')->id;
                $cart->cart_product_id = $productAdd->pro_id;
                $cart->cart_product_image = $productAdd->pro_avatar;
                $cart->cart_product_price = $productAdd->pro_price;
                $cart->cart_product_total = $productAdd->pro_price * 1;
                $cart->cart_product_quantity = 1;
                $cart->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $cart->save();
                return redirect()->route('cart')->with('success', 'Thêm giỏ hàng thành công');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm giỏ hàng thất bại ! Vui lòng thử lại');
        }
    }
    //cap nhap gio hang
    public function updateCart(Request $request, $cart_id)
    {
        // $this->AuthLogin();
        if ($request->product_quatity <= 0) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm phải lớn hơn 0');
        }
        $cart = cart::where('cart_id', $cart_id)->first();
        $qty = $request->product_quatity - $cart->cart_product_quantity;
        $pro_qty = DB::table('products')->where('pro_id', $cart->cart_product_id)->first()->pro_qty;
        if ($qty > $pro_qty) {
            return redirect()->route('cart')->with('error', 'Số lượng sản phẩm không đủ');
        } else {
            DB::table('products')->where('pro_id', $cart->cart_product_id)->update([
                'pro_qty' => DB::table('products')->where('pro_id', $cart->cart_product_id)->first()->pro_qty - $qty,
            ]);
            $cart->cart_product_quantity = $request->product_quatity;
            $cart->cart_product_total = $request->product_quatity * $cart->cart_product_price;
            $cart->save();
            return redirect()->route('cart')->with('success', 'Cập nhật giỏ hàng thành công');
        }
    }
    //xoa 1 sp khoi gio hang
    public function deleteCart($cart_id)
    {
        // $this->AuthLogin();
        $pro_id = DB::table('cart')->where('cart_id', $cart_id)->first()->cart_product_id;
        $cart = cart::where('cart_id', $cart_id)->first();
        $cart->delete();
        return redirect()->route('cart')->with('success', 'Xóa giỏ hàng thành công');
    }
    //xoa toan bo gio hang
    public function clearCart()
    {
        // $this->AuthLogin();
        $products = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        $cart = cart::where('cart_user_id', Session::get('user')->id)->delete();
        return redirect()->route('cart')->with('success', 'Xóa giỏ hàng thành công');
    }


    // trang thanh toan
    public function checkout()
    {
        // $this->AuthLogin();
        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)
            ->join('products', 'products.pro_id', '=', 'cart.cart_product_id')
            ->get();
        $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        $total2 = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
        if (Session::get('cou_value')) {
            $total = $total - (Session::get('cou_value') * $total);
        }
        $address = DB::table('address')->where('user_id', Session::get('user')->id)->get();
        $countCart = count($cart);
        return view('frontend.cart.checkout', compact('cart', 'total', 'address', 'countCart', 'total2'));
    }

    // them voucher
    public function postCoupon(Request $request)
    {
        // $this->AuthLogin();
        $checkCoupon = DB::table('coupons')
            ->join('coupons_user', 'coupons.cou_id', '=', 'coupons_user.cou_id')
            ->where('coupons_user.user_id', Session::get('user')->id)
            ->where('coupons.cou_code', $request->coupon_code)
            ->first();
        if ($checkCoupon) {
            if ($checkCoupon->cou_expired_date  < Carbon::now()) {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn');
            } else if ($checkCoupon->cou_status == 1) {
                return redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
            } else if ($checkCoupon->cou_number == 0) {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết số lượng');
            } else {
                Session::put('cou_value', $checkCoupon->cou_value);
                Session::put('cou_code', $checkCoupon->cou_code);
                return redirect()->back()->with('success', 'Nhập mã giảm giá thành công');
            }
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
        }
    }
    //xoa voicher
    public function deleteCoupon()
    {
        // $this->AuthLogin();
        if (Session::get('cou_value')) {
            Session::forget('cou_code');
            Session::forget('cou_value');
            return redirect()->back()->with('success', 'Mã giảm giá đã được hủy');
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại');
        }
    }
    //ham chuyen tien tu VND sang USD de thanh toan paypal
    public function getMoney($type)
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
    // thanh toan lien quan den MOMO

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    // thanh toan
    public function postCheckout(Request $request)
    {
        // $this->AuthLogin();
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
        if ($request->payment_method == 'Paypal') {
            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            if (Session::get('cou_value') != null) {
                $value = round(($total - (Session::get('cou_value') * $total)) / 22580);
            } else {
                $value = round($total / 22850);
            }
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
        } else if ($request->payment_method == 'VnPay') {

            $vnp_TmnCode = env('vnp_TmnCode');
            $vnp_HashSecret = env('vnp_HashSecret');
            $vnp_Url = env('vnp_Url');
            $vnp_Returnurl = env('vnp_Returnurl');
            $vnp_apiUrl = env('vnp_apiUrl');
            //Config input format
            //Expire
            // $startTime = Carbon::now('Asia/Ho_Chi_Minh');
            // $expire = $startTime->addMinutes(10);

            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_TxnRef = 'test' . date('YmdHis');
            $vnp_OrderInfo = "Thanh toán đơn hàng";
            $vnp_OrderType = 'billpayment';
            if (Session::get('cou_value') != null) {
                $vnp_Amount = (int)($total - ($total * Session::get('cou_value'))) * 100;
            } else {
                $vnp_Amount = (int)$total * 100;
            }
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version
            // $vnp_ExpireDate = $expire->format('YmdHis');

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                // "vnp_ExpireDate" => $vnp_ExpireDate,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00', 'message' => 'success', 'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
        } else if ($request->payment_method == 'MOMO') {
            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            if (Session::get('cou_value') != null) {
                $total = $total - $total * Session::get('cou_value');
            } else {
                $total = $total;
            }
            $endpoint = env('endpoint');
            $partnerCode = env('partnerCode');
            $accessKey = env('accessKey');
            $secretKey = env('secretKey');
            $orderInfo = "Thanh toán qua MoMo";
            $amount = (int)$total;
            $orderId = time() . "";
            $redirectUrl = env('redirectUrl');
            $ipnUrl = env('ipnUrl');
            $extraData = "";

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json
            //Just a example, please check more in there
            return redirect()->to($jsonResult['payUrl']);
            // header('Location: ' . $jsonResult['payUrl']);
        } else {
            $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            if (Session::get('cou_value')) {
                $total = $total - $total * Session::get('cou_value');
            } else {
                $total = $total;
            }
            $data = array();
            //them vo orders
            $data['user_id'] = Session::get('user')->id;
            $data['price_total'] = $total;
            $data['order_code'] = Session::get('cou_code') ? Session::get('cou_code') : '';
            $data['address'] = DB::table('address')->where('user_id', Session::get('user')->id)->where('isDefault', 1)->first()->address;
            $data['order_type'] = $request->payment_method;
            $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $order_id = DB::table('orders')->insertGetId($data);
            //them vo order_details
            foreach ($cart as $key => $value) {
                $data_detail = array();
                $data_detail['order_id'] = $order_id;
                $data_detail['product_id'] = $value->cart_product_id;
                $data_detail['product_price'] = Session::get('cou_value') ? $value->cart_product_price - (Session::get('cou_value') * $value->cart_product_price) : $value->cart_product_price;
                $data_detail['product_quantity'] = $value->cart_product_quantity;
                $data_detail['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
                DB::table('order_details')->insert($data_detail);
            }
            //thong bao don hang moi
            DB::table('notifications')->insert([
                'type' => 'Đơn hàng mới',
                'notification' => 'Có đơn hàng mới từ ' . Session::get('user')->name . ' với mã đơn hàng #' . $order_id,
                'role' => 1,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
            if ($total  >= 1000000) {
                $checkCoupon2 = DB::table('coupons')->where('cou_status', 0)->get();
                if (count($checkCoupon2) > 0) {
                    DB::table('notifications')->insert([
                        'type' => 'Mã khuyến mãi',
                        'role' => 0,
                        'user_id' => Session::get('user')->id,
                        'notification' => 'Bạn đã được nhận mã giảm giá',
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
                    //tặng mã giảm giá
                    DB::table('coupons_user')
                        ->insert([
                            'user_id' => Session::get('user')->id,
                            'cou_id' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_id,
                            'status' => 0,
                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                        ]);
                }
            }
            //xoa gio hang

            DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();
            if (Session::get('cou_value')) {
                DB::table('coupons')->where('cou_code', Session::get('cou_code'))
                    ->update(['cou_number' => DB::table('coupons')
                        ->where('cou_code', Session::get('cou_code'))->first()->cou_number - 1]);

                Session::forget('cou_value');
                Session::forget('cou_code');
            }
            return view('frontend.cart.success');
        }
    }
    //ham xu ly thanh toan momo
    public function momo()
    {
        if ((isset($_GET['message']) && $_GET['message'] === 'Successful.')) {
            $this->Action($_GET['amount'], "Thanh toán qua MoMo");
            return redirect()->route('success');
        } else {
            return redirect()->route('cart')->with('error', 'Giao dịch thất bại');
        }
    }
    //ham xu ly thanh toan vnpay
    public function vnpay()
    {
        if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == '00') {
            $this->Action($_GET['vnp_Amount'] / 100, "Thanh toán qua VNPAY");
            return redirect()->route('success');
        } else {
            return Redirect()->route('cart')->with('error', 'Giao dịch không thành công');
        }
    }
    //ham thành công paypal
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {



            $cart = DB::table('cart')
                ->join('products', 'products.pro_id', '=', 'cart.cart_product_id')
                ->where('cart_user_id', Session::get('user')->id)
                ->get();
            $total = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->sum('cart_product_total');
            if (Session::get('cou_value')) {
                $total = $total - ($total * Session::get('cou_value'));
            } else {
                $total = $total;
            }
            $data = array();
            //check co ma giam gia ko?
            //them vo orders
            $data['user_id'] = Session::get('user')->id;
            $data['price_total'] = Session::get('cou_value') ? $total - (Session::get('cou_value') * $total) : $total;
            $data['order_code'] = Session::get('cou_code') ? Session::get('cou_code') : '';
            $data['address'] = DB::table('address')->where('user_id', Session::get('user')->id)->where('isDefault', 1)->first()->address;
            $data['order_type'] = "Paypal";
            $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $order_id = DB::table('orders')->insertGetId($data);
            //them vo order_details
            foreach ($cart as $key => $value) {
                $data_detail = array();
                $data_detail['order_id'] = $order_id;
                $data_detail['product_id'] = $value->cart_product_id;
                $data_detail['product_price'] = Session::get('cou_value') ? $value->cart_product_price - (Session::get('cou_value') * $value->cart_product_price) : $value->cart_product_price;
                $data_detail['product_quantity'] = $value->cart_product_quantity;
                $data_detail['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
                DB::table('order_details')->insert($data_detail);
            }
            //thong bao don hang moi
            DB::table('notifications')->insert([
                'type' => 'Đơn hàng mới',
                'notification' => 'Có đơn hàng mới từ ' . Session::get('user')->name . ' với mã đơn hàng #' . $order_id,
                'role' => 1,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
            if ($total  >= 1000000) {
                $checkCoupon2 = DB::table('coupons')->where('cou_status', 0)->get();
                if (count($checkCoupon2) > 0) {
                    DB::table('notifications')->insert([
                        'type' => 'Mã khuyến mãi',
                        'role' => 0,
                        'user_id' => Session::get('user')->id,
                        'notification' => 'Bạn đã được nhận mã giảm giá',
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
                    //tặng mã giảm giá
                    DB::table('coupons_user')
                        // ->where('code', Session::get('cou_code'))
                        // ->where('user_id', Session::get('user')->id)
                        ->insert([
                            'user_id' => Session::get('user')->id,
                            'cou_id' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_id,
                            'status' => 0,
                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                        ]);
                }
            }
            //xoa gio hang
            DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();
            if (Session::get('cou_value')) {
                DB::table('coupons')->where('cou_code', Session::get('cou_code'))
                    ->update(['cou_number' => DB::table('coupons')
                        ->where('cou_code', Session::get('cou_code'))->first()->cou_number - 1]);
                Session::forget('cou_value');
                Session::forget('cou_code');
            }
            return redirect()->route('success');
        } else {
            return redirect()
                ->route('cart')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    //ham huy paypal
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('cart')
            ->with('error', $response['message'] ?? 'Ban da huy giao dich.');
    }
    public function success()
    {
        return view('frontend.cart.success');
    }
    //ham xu ly du lieu them vao database
    static function Action($price, $type)
    {
        $products = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        foreach ($products as $product) {
            DB::table('products')->where('pro_id', $product->cart_product_id)->update([
                'pro_qty' => DB::table('products')->where('pro_id', $product->cart_product_id)->first()->pro_qty + $product->cart_product_quantity,
            ]);
        }

        $cart = DB::table('cart')->where('cart_user_id', Session::get('user')->id)->get();
        $data = array();
        //them vo orders
        $data['user_id'] = Session::get('user')->id;
        $data['price_total'] = $price;
        $data['order_code'] = Session::get('cou_code') ? Session::get('cou_code') : '';
        $data['address'] = DB::table('address')->where('user_id', Session::get('user')->id)->where('isDefault', 1)->first()->address;
        $data['order_type'] = $type;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $order_id = DB::table('orders')->insertGetId($data);
        //them vo order_details
        foreach ($cart as $key => $value) {
            $data_detail = array();
            $data_detail['order_id'] = $order_id;
            $data_detail['product_id'] = $value->cart_product_id;
            $data_detail['product_price'] = Session::get('cou_value') ? $value->cart_product_price - (Session::get('cou_value') * $value->cart_product_price) : $value->cart_product_price;
            $data_detail['product_quantity'] = $value->cart_product_quantity;
            $data_detail['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            DB::table('order_details')->insert($data_detail);
        }
        //thong bao don hang moi
        DB::table('notifications')->insert([
            'type' => 'Đơn hàng mới',
            'notification' => 'Có đơn hàng mới từ ' . Session::get('user')->name . ' với mã đơn hàng #' . $order_id,
            'role' => 1,
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
        ]);
        if ($price  >= 1000000) {
            $checkCoupon2 = DB::table('coupons')->where('cou_status', 0)->get();
            if (count($checkCoupon2) > 0) {
                DB::table('notifications')->insert([
                    'type' => 'Mã khuyến mãi',
                    'role' => 0,
                    'user_id' => Session::get('user')->id,
                    'notification' => 'Bạn đã được nhận mã giảm giá',
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                //tặng mã giảm giá
                DB::table('coupons_user')
                    ->insert([
                        'user_id' => Session::get('user')->id,
                        'cou_id' => DB::table('coupons')->where('cou_status', 0)->inRandomOrder()->first()->cou_id,
                        'status' => 0,
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                    ]);
            }
        }
        //xoa gio hang
        DB::table('cart')->where('cart_user_id', Session::get('user')->id)->delete();
        if (Session::get('cou_value')) {
            DB::table('coupons')->where('cou_code', Session::get('cou_code'))
                ->update(['cou_number' => DB::table('coupons')
                    ->where('cou_code', Session::get('cou_code'))->first()->cou_number - 1]);
            Session::forget('cou_value');
            Session::forget('cou_code');
        }
        return redirect()->route('success');
    }
}
