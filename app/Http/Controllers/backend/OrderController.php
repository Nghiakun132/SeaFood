<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use PDF;

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
        // $this->AuthLogin();
        $orders = DB::table('orders')->orderBy('order_id', 'DESC')->get();
        return view('backend.orders.index', compact('orders'));
    }
    public function changeStatus($id)
    {
        // $this->AuthLogin();
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
        // $this->AuthLogin();
        DB::table('orders')->where('order_id', $id)->delete();
        return redirect()->back();
    }
    public function show($id)
    {
        // $this->AuthLogin();
        $orders = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.pro_id')
            ->where('order_id', $id)
            ->select('order_details.*', 'products.pro_name')
            ->get();
        return view('backend.orders.detail', compact('orders'));
    }
    public function print($id)
    {
        // $this->AuthLogin();
        $data = [
            'orders' => DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('order_id', $id)->first(),
            'order_details' => DB::table('order_details')
                ->join('products', 'order_details.product_id', '=', 'products.pro_id')
                ->where('order_id', $id)
                ->select('order_details.*', 'products.pro_name')
                ->get(),
            'sum' => DB::table('orders')->where('order_id', $id)->first()->price_total,
            'day' => Carbon::now('Asia/Ho_Chi_Minh')->format('d'),
            'month' => Carbon::now('Asia/Ho_Chi_Minh')->format('m'),
            'year' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y'),
            'money' => $this->convert_number_to_words(DB::table('orders')->where('order_id', $id)->first()->price_total + 0),

        ];
        $pdf = PDF::loadView('backend.orders.print', $data);
        return $pdf->stream('invoice.pdf');
    }
    function convert_number_to_words($number) {

		$hyphen      = ' ';
		$conjunction = ' ';
		$separator   = ' ';
		$negative    = 'âm ';
		$decimal     = ' phẩy ';
		$one		 = 'mốt';
		$ten         = 'lẻ';
		$dictionary  = array(
		0                   => 'Không',
		1                   => 'Một',
		2                   => 'Hai',
		3                   => 'Ba',
		4                   => 'Bốn',
		5                   => 'Năm',
		6                   => 'Sáu',
		7                   => 'Bảy',
		8                   => 'Tám',
		9                   => 'Chín',
		10                  => 'Mười',
		11                  => 'Mười một',
		12                  => 'Mười hai',
		13                  => 'Mười ba',
		14                  => 'Mười bốn',
		15                  => 'Mười lăm',
		16                  => 'Mười sáu',
		17                  => 'Mười bảy',
		18                  => 'Mười tám',
		19                  => 'Mười chín',
		20                  => 'Hai mươi',
		30                  => 'Ba mươi',
		40                  => 'Bốn mươi',
		50                  => 'Năm mươi',
		60                  => 'Sáu mươi',
		70                  => 'Bảy mươi',
		80                  => 'Tám mươi',
		90                  => 'Chín mươi',
		100                 => 'trăm',
		1000                => 'ngàn',
		1000000             => 'triệu',
		1000000000          => 'tỷ',
		1000000000000       => 'nghìn tỷ',
		1000000000000000    => 'ngàn triệu triệu',
		1000000000000000000 => 'tỷ tỷ'
		);

		if (!is_numeric($number)) {
			return false;
		}

		// if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
		// 	// overflow
		// 	trigger_error(
		// 	'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
		// 	E_USER_WARNING
		// 	);
		// 	return false;
		// }

		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
			break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= strtolower( $hyphen . ($units==1?$one:$dictionary[$units]) );
				}
			break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= strtolower( $conjunction . ($remainder<10?$ten.$hyphen:null) . $this->convert_number_to_words($remainder) );
				}
			break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number - ($numBaseUnits*$baseUnit);
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= strtolower( $remainder < 100 ? $conjunction : $separator );
					$string .= strtolower( $this->convert_number_to_words($remainder) );
				}
			break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}

		return $string;
	}
}
