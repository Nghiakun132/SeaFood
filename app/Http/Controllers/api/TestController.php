<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $month = Carbon::now('Asia/Ho_Chi_Minh')->month;
        $doanhthu = $this->LayDoanhThuThangHienTai($month);
        return response()->json([
            'doanhthu' => $doanhthu,
        ]);
    }
    public function thang(Request $request)
    {
        $month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->month;
        $doanhthu = $this->LayDoanhThuTungNgay($month);
        return response()->json([
            'doanhthu' => $doanhthu,
        ]);
    }
    public function ngay7(Request $request)
    {
        $day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7);
        $doanhthu = $this->LayDoanhThu7Ngay($day);
        return response()->json([
            'doanhthu' => $doanhthu,
        ]);
    }
    public function hientai(){

        $year = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $doanhthu = $this->layDoanhThuTungThang($year);
        return response()->json([
            'doanhthu' => $doanhthu,
        ]);
    }
    static function layDoanhThuTungThang($year)
    {
        $doanhthuTungThang = DB::table('orders')
            ->where('order_status', '<>',2)
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('MONTH(orders.created_at) as thang'))
            ->whereYear('orders.created_at', '=', $year)
            ->groupBy('thang')
            ->get();

        return $doanhthuTungThang;
    }
    static function LayDoanhThuTungNgay($thang)
    {
        $doanhthuTungNgay = DB::table('orders')
            ->where('order_status', '<>',2)
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('DAY(orders.created_at) as ngay'))
            ->whereMonth('orders.created_at', '=', $thang)
            ->groupBy('ngay')
            ->get();
        return $doanhthuTungNgay;
    }
    static function LayDoanhThu7Ngay($day)
    {
        $doanhthu7Ngay = DB::table('orders')
            ->where('order_status', '<>',2)
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('DAY(orders.created_at) as ngay'))
            ->where('orders.created_at', '>=', $day)
            ->where('orders.created_at', '<=', Carbon::now('Asia/Ho_Chi_Minh'))
            ->groupBy('ngay')
            ->get();
        return $doanhthu7Ngay;
    }
    static function LayDoanhThuThangHienTai($month)
    {
        $doanhthuThangHienTai = DB::table('orders')
            ->where('order_status', '<>',2)
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('DAY(orders.created_at) as ngay'))
            ->whereMonth('orders.created_at', '=', $month)
            ->groupBy('ngay')
            ->get();
        return $doanhthuThangHienTai;
    }

}
