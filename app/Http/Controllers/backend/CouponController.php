<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CouponController extends Controller
{
    public function AuthLogin()
    {
        $ad = Session::get('admins');
        if ($ad) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->send();
        }
    }
    public function index()
    {
        $this->AuthLogin();
        $cp = DB::table('coupons')->get();
        return view('backend.coupon.index', compact('cp'));
    }
    public function store(Request $request)
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = substr(str_shuffle($str), 0, 12);
        $check = DB::table('coupons')->where('cou_code', $code)->first();
        if ($check) {
            $this->store($request);
        } else {
            DB::table('coupons')->insert([
                'cou_code' => $code,
                'cou_value' => $request->cou_value / 100,
                'cou_number' => $request->cou_number,
                'cou_expired_date' => $request->cou_date,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
            return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
        }
    }
    public function destroy($id)
    {
        $this->AuthLogin();
        DB::table('coupons')->where('cou_id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công');
    }
    public function changeStatus($id)
    {
        $this->AuthLogin();
        $cp = DB::table('coupons')->where('cou_id', $id)->first();
        if ($cp->cou_status == 0) {
            DB::table('coupons')->where('cou_id', $id)->update([
                'cou_status' => 1
            ]);
        } else {
            DB::table('coupons')->where('cou_id', $id)->update([
                'cou_status' => 0
            ]);
        }
        return redirect()->back()->with('success', 'Thay đổi trạng thái thành công');
    }
}
