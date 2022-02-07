<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Session;

class UserController extends Controller
{
    public function register()
    {
        return view('frontend.user.register');
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|min:10|unique:users,phone',
            'address' => 'required',
            'password' => 'required|min:8|max:20',
            're_password' => 'required|same:password',

        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.numeric' => 'Bạn chưa nhập đúng định dạng số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            're_password.required' => 'Bạn chưa nhập lại mật khẩu',
            're_password.same' => 'Mật khẩu không trùng khớp',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = md5($request->password);
        $user->phone = $request->phone;
        $user->avatar = $request->avatar;
        $user->type = $request->type;
        $user->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $user->save();
        $user_id = User::orderBy('id', 'desc')->first();
        $address = new address();
        $address->user_id = $user_id->id;
        $address->address = $request->address;
        $address->save();
        Session::forget('userResisgter');
        return redirect()->route('login')->with('success', 'Đăng ký thành công');
    }

    public function login()
    {
        return view('frontend.user.login');
    }
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'password.required' => 'Bạn chưa nhập mật khẩu',
        ]);
        $email = $request->email;
        $password = md5($request->password);
        $check = User::where('email', $email)->first();
        if ($check) {
            if ($check->password == $password) {
                Session::put('user', $check);
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('error', 'Sai mật khẩu');
            }
        } else {
            return redirect()->back()->with('error', 'Tài khoản không tồn tại');
        }
    }

    public function loginGG()
    {
        try {
            return Socialite::driver('google')->stateless()->redirect();
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
    public function loginGGCallback()
    {
        try {
            $userLogin = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $userLogin->email)->first();
            if ($user) {
                Session::put('user', $user);
                return redirect()->route('home');
            } else {
                Session::put('userResisgter', $userLogin);
                return redirect()->route('register');
            }
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Đăng nhập không thành công!! Vui lòng thử lại');
        }
    }
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('home');
    }




}
