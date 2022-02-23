<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class HomeController extends Controller
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
        $revenue = DB::table('orders')->select(DB::raw('sum(price_total) as total'))->where('order_status','<>',2)->first();
        $user = DB::table('users')->count();
        $comments = DB::table('comments')->count();
        $orders = DB::table('orders')->count();
        $products = DB::table('products')->get();
        return view('backend.home.index', compact('revenue','user','comments','orders','products'));
    }
    public function Login()
    {
        return view('backend.home.login');
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
            if ($admins->password == md5($password)) {
                Session()->put('admins', $admins);
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
        $this->AuthLogin();
        $admin = admins::find($id);
        return view('backend.home.profile', compact('admin'));
    }
    public function post_change_profile(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
        ]);
        $admin = admins::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->birthday = $request->birthday;
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
}
