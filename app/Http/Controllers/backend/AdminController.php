<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{
    // public function AuthLogin()
    // {
    //     $ad = Session::get('admins');
    //     if ($ad) {
    //         return redirect()->route('admin.home');
    //     } else {
    //         return redirect()->route('admin.login')->send();
    //     }
    // }
    public function __construct(admins $admins)
    {
        $this->admins = $admins;
    }
    public function index()
    {
        $staff = $this->admins->all();
        return view('backend.staffs.index', compact('staff'));
    }
    public function store(Request $request)
    {
        //$this->authLogin();
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
            'password' => Hash::make('12345678'),
        ];
        $this->admins->create($data);
        return redirect()->back()->with('success', 'Thêm thành công');
    }
    public function destroy($id)
    {
        //$this->authLogin();
        $this->admins->find($id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function promoteStaff($id)
    {
        //$this->authLogin();
        $admin = $this->admins->find($id);
        if ($admin->role == 1) {
            $this->admins->where('id', $id)->update(['role' => 0]);
            return redirect()->back()->with('success', 'Cấp quyền thành công');
        } else {
            $this->admins->where('id', $id)->update(['role' => 1]);
            return redirect()->back()->with('success', 'Cấp quyền thành công');
        }
    }

    public function getNotifications()
    {
        $notis = DB::table('notifications')->where('role', 1)->get();
        return view('backend.home.notification', compact('notis'));
    }
    public function destroyNotification($id)
    {
        DB::table('notifications')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function readNotification($id)
    {
        DB::table('notifications')->where('id', $id)->update(['read' => 1]);
        return redirect()->route('admin.order');
    }
    public function destroyAllNotification()
    {
        DB::table('notifications')->where('role', 1)->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function statistics()
    {

        if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
            $from_date = $_GET['from_date'];
            $to_date = $_GET['to_date'];
            // format date
            if ($from_date == '') {
                $details = DB::table('orders')
                    ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
                    ->join('products', 'order_details.product_id', '=', 'products.pro_id')
                    ->select('products.pro_name', DB::raw('SUM(order_details.product_quantity) as quantity'), DB::raw('SUM(order_details.product_price) as price'))
                    ->where('orders.order_status', '<>', 2)
                    ->where('order_details.created_at', '<=', $to_date)
                    ->groupBy('products.pro_name')
                    ->get();
                //format to array
                $details = json_decode(json_encode($details), true);
                return view('backend.home.statistic', compact('details'));
            } else {
                $details = DB::table('orders')
                    ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
                    ->join('products', 'order_details.product_id', '=', 'products.pro_id')
                    ->select('products.pro_name', DB::raw('SUM(order_details.product_quantity) as quantity'), DB::raw('SUM(order_details.product_price) as price'))
                    ->where('orders.order_status', '<>', 2)
                    ->whereBetween('order_details.created_at', [$from_date, $to_date])
                    ->groupBy('products.pro_name')
                    ->get();
                //format to array
                $details = json_decode(json_encode($details), true);
                return view('backend.home.statistic', compact('details'));
            }
        }
        $details = [];
        return view('backend.home.statistic', compact('details'));
    }
}
