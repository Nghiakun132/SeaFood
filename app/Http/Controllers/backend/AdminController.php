<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class AdminController extends Controller
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
    public function __construct(admins $admins)
    {
        $this->admins = $admins;
    }
    public function index()
    {
        $this->AuthLogin();
        $staff = $this->admins->all();
        return view('backend.staffs.index', compact('staff'));
    }
    public function store(Request $request)
    {
        $this->authLogin();
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:admins,email',
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Bạn chưa nhập số điện thoại'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => md5('12345678'),
        ];
        $this->admins->create($data);
        return redirect()->back()->with('success', 'Thêm thành công');
    }
    public function destroy($id)
    {
        $this->authLogin();
        $this->admins->find($id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function up_level($id)
    {
        $this->authLogin();
        $admin = $this->admins->find($id);
        if ($admin->role == 1) {
            $this->admins->where('id', $id)->update(['role' => 0]);
            return redirect()->back()->with('success', 'Cấp quyền thành công');
        } else {
            $this->admins->where('id', $id)->update(['role' => 1]);
            return redirect()->back()->with('success', 'Cấp quyền thành công');
        }
    }

    public function Notification()
    {
        $this->AuthLogin();
        $noti = DB::table('notifications')->where('role', 1)->get();
        return view('backend.home.notification', compact('noti'));
    }
    public function destroyNotification($id)
    {
        $this->AuthLogin();
        DB::table('notifications')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function readNotification($id)
    {
        $this->AuthLogin();
        DB::table('notifications')->where('id', $id)->update(['read' => 1]);
        return redirect()->route('admin.order');
    }
    public function statistic()
    {
        $this->AuthLogin();
        // if (isset($_GET['thong_ke'])) {
        //     $thongke = $_GET['thong_ke'];
        //     if ($thongke == '7_ngay') {
        //         $day = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7);
        //         $doanhthu = $this->LayDoanhThu7Ngay($day);
        //         return view('backend.home.statistic', compact('doanhthu'));
        //     } else if ($thongke == 'thang') {
        //         $day = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1);
        //         $doanhthu = $this->LayDoanhThuTungNgay($day);
        //         return view('backend.home.statistic', compact('doanhthu'));
        //     } else if ($thongke == 'nam') {
        //         $year = Carbon::now('Asia/Ho_Chi_Minh')->year;
        //         $doanhthu = $this->layDoanhThuTungThang($year);
        //         return view('backend.home.statistic', compact('doanhthu'));
        //     }
        // }
        // $month = Carbon::now('Asia/Ho_Chi_Minh')->month;
        // $doanhthu = $this->LayDoanhThuThangHienTai($month);
        return view('backend.home.statistic');
    }
    static function layDoanhThuTungThang($year)
    {
        $doanhthuTungThang = DB::table('orders')
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('MONTH(orders.created_at) as thang'))
            ->whereYear('orders.created_at', '=', $year)
            ->groupBy('thang')
            ->get();

        return $doanhthuTungThang;
    }
    static function LayDoanhThuTungNgay($thang)
    {
        $doanhthuTungNgay = DB::table('orders')
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('DAY(orders.created_at) as ngay'))
            ->whereMonth('orders.created_at', '=', $thang)
            ->groupBy('ngay')
            ->get();
        return $doanhthuTungNgay;
    }
    static function LayDoanhThu7Ngay($day)
    {
        $doanhthu7Ngay = DB::table('orders')
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
            ->select(DB::raw('SUM(price_total) as doanhthu'), DB::raw('DAY(orders.created_at) as ngay'))
            ->whereMonth('orders.created_at', '=', $month)
            ->groupBy('ngay')
            ->get();
        return $doanhthuThangHienTai;
    }
}
