<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Carbon\Carbon;
use Hamcrest\Core\IsTypeOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class HomeController extends Controller
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
    public function index()
    {
        // $this->AuthLogin();
        $revenue = DB::table('orders')->select(DB::raw('sum(price_total) as total'))->where('order_status', '<>', 2)->first();
        $user = DB::table('users')->count();
        $comments = DB::table('comments')->count();
        $orders = DB::table('orders')->count();
        $products = DB::table('products')->get();
        $import = DB::table('import_products')->sum('ip_total');
        $product_sell = DB::table('products')
            ->join('order_details', 'products.pro_id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.order_id')
            ->where('orders.order_status', '<>', 2)
            ->select(DB::raw('sum(order_details.product_quantity) as total'), 'product_id', 'pro_name','pro_qty')
            ->groupBy('order_details.product_id', 'products.pro_name','products.pro_qty')
            ->get();
        return view('backend.home.index', compact('revenue', 'user', 'comments', 'orders', 'products', 'import', 'product_sell'));
    }
    public function Login()
    {
        $cookie = Cookie::get('admins');
        return view('backend.home.login', compact('cookie'));
    }
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Bạn chưa nhập mật khẩu',
        ]);
        $email = $request->email;
        $password = $request->password;
        $admins = admins::where('email', $email)->first();
        if ($admins) {
            if (Hash::check($password, $admins->password)) {
                DB::table('activities_log')->insert([
                    'account_id' => $admins->id,
                    'role' => 0,
                    'activity' => 'Đăng nhập',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    'date_time' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                Session::put('admins', $admins);
                Cookie::queue('admins', $admins->email, 60);
                DB::table('admins')->where('id', $admins->id)->update(['status' => 1]);
                return redirect()->route('admin.home');
            } else {
                return redirect()->back()->with('error', 'Mật khẩu không đúng');
            }
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại');
        }
    }
    public function Logout()
    {
        DB::table('admins')->where('id', Session::get('admins')->id)->update(['status' => 0]);
        Session()->forget('admins');
        return redirect()->route('admin.login');
    }
    public function change_profile($id)
    {
        // $this->AuthLogin();
        $admin = admins::find($id);
        $birthday = explode('-', $admin->birthday);
        //tính số tuổi
        $toDay = Carbon::now('Asia/Ho_Chi_Minh');
        $age = $toDay->diffInYears($admin->birthday);
        return view('backend.home.profile', compact('admin',  'age'));
    }
    public function post_change_profile(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $id,
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
        ]);
        $admin = admins::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->birthday != null) {
            $admin->birthday = $request->birthday;
        }
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $admin->save();

        if ($avatar  = $request->file('avatar')) {
            $file_name = $avatar->getClientOriginalName();
            $avatar->move('uploads/avatar', $file_name);
            $admin->avatar = $file_name;
            $admin->save();
        }
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:20',
            're_password' => 'required|min:6|max:20|same:new_password',
        ], [
            'old_password.required' => 'Bạn chưa nhập mật khẩu cũ',
            'new_password.required' => 'Bạn chưa nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'new_password.max' => 'Mật khẩu mới phải có nhiều nhất 20 ký tự',
            're_password.required' => 'Bạn chưa nhập lại mật khẩu mới',
            're_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            're_password.max' => 'Mật khẩu mới phải có nhiều nhất 20 ký tự',
            're_password.same' => 'Mật khẩu mới không trùng khớp',
        ]);
        $admin = admins::find(Session::get('admins')->id);
        if (Hash::check($request->old_password, $admin->password)) {
            $admin->password = Hash::make($request->password);
            $admin->save();
            return redirect()->back()->with('success', 'Cập nhật thành công');
        } else {
            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng');
        }
    }
    public function checkCart()
    {
        Artisan::call('cart:check');
        return redirect()->back();
    }
    public function test()
    {
        //get ip user
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        //get device
    }
}
