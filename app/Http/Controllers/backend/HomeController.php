<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Illuminate\Http\Request;
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
        return view('backend.home.index');
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
            if ($admins->password == $password) {
                Session()->put('admins', $admins);
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
        Session()->forget('admins');
        return redirect()->route('admin.login');
    }
}
