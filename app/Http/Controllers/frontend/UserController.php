<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Session;

class UserController extends Controller
{
    public function AuthLogin()
    {
        $user = Session::get('user')->id;
        if ($user) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->send();
        }
    }

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
        $user->password = Hash::make($request->password);
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
        $password = $request->password;
        $check = User::where('email', $email)->first();
        if ($check) {
            if (Hash::check($password, $check->password)) {
                DB::table('activities_log')->insert([
                    'account_id' => $check->id,
                    'role' => 1,
                    'activity' => 'Đăng nhập',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    'date_time' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
                DB::table('users')->where('id', $check->id)->update(['status' => Carbon::now('Asia/Ho_Chi_Minh')]);
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
                DB::table('users')->where('id', $user->id)->update(['status' => Carbon::now('Asia/Ho_Chi_Minh')]);
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
        DB::table('users')->where('id', Session::get('user')->id)->update(['status' => 1]);
        Session::forget('user');
        return redirect()->route('home');
    }

    public function notifications()
    {
        // $this->AuthLogin();
        $user = Session::get('user')->id;
        $notifications = DB::table('notifications')->where('user_id', $user)->orderBy('id', 'desc')->get();
        return view('frontend.notification.index', compact('notifications'));
    }
    public function readNotifications($id)
    {
        // $this->AuthLogin();
        DB::table('notifications')->where('id', $id)->update(['read' => 1]);
        return redirect()->route('notifications')->with('success', 'Đã đọc thông báo');
    }
    public function deleteNotifications($id)
    {
        // $this->AuthLogin();
        DB::table('notifications')->where('id', $id)->delete();
        return redirect()->route('notifications')->with('success', 'Đã xóa thông báo');
    }
    public function deleteAllNotifications()
    {
        // $this->AuthLogin();
        DB::table('notifications')->where('user_id', Session::get('user')->id)->delete();
        return redirect()->route('notifications')->with('success', 'Đã xóa tất cả thông báo');
    }

    public function profile()
    {
        // $this->AuthLogin();
        $id = Session::get('user')->id;
        $user = User::find($id);
        return view('frontend.user.index', compact('user'));
    }
    public function postProfile(Request $request)
    {
        // $this->AuthLogin();
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|numeric|min:10|unique:users,phone,' . Session::get('user')->id,
            'email' => 'required|email|unique:users,email,' . Session::get('user')->id,
        ], [
            'name.required' => 'Bạn chưa nhập tên',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.numeric' => 'Bạn chưa nhập đúng định dạng số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn chưa nhập đúng định dạng email',
            'email.unique' => 'Email đã tồn tại',
        ]);
        if (Session::get('user')->type == 'Account') {
            $id = Session::get('user')->id;
            $user = User::find($id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            if ($request->avatar) {
                $file = $request->avatar;
                $file_name = $file->getClientOriginalName();
                $file->move('uploads/avatar', $file_name);
                $user->avatar = $file_name;
            }
            $user->save();
            return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật thông tin khi đăng nhập bằng Google');
        }
    }
    public function changePassword(Request $request)
    {
        // $this->AuthLogin();
        $this->validate($request, [
            'old' => 'required',
            'new' => 'required|min:8',
            'new_re' => 'required|same:new',
        ], [
            'old.required' => 'Bạn chưa nhập mật khẩu cũ',
            'new.required' => 'Bạn chưa nhập mật khẩu mới',
            'new.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'new_re.required' => 'Bạn chưa nhập lại mật khẩu mới',
            'new_re.same' => 'Mật khẩu mới và lại mật khẩu mới không trùng nhau',
        ]);
        $old = $request->old;
        $new = $request->new;

        $id = Session::get('user')->id;
        $user = User::find($id);
        if (Hash::check($old, $user->password)) {
            $user->password = Hash::make($new);
            $user->save();
            DB::table('activities_log')->insert([
                'account_id' => $check->id,
                'role' => 1,
                'activity' => 'Đổi mật khẩu',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'date_time' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->back()->with('error', 'Mật khẩu không chính xác');
        }
    }
    public function address()
    {
        // $this->AuthLogin();
        $id = Session::get('user')->id;
        $user = User::join('address', 'users.id', '=', 'address.user_id')->where('users.id', $id)->get();
        return view('frontend.user.address', compact('user'));
    }
    public function addAddress(Request $request)
    {
        // $this->AuthLogin();
        $this->validate(
            $request,
            [
                'address' => 'required|unique:address,address',
            ],
            [
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'address.unique' => 'Địa chỉ đã tồn tại',
            ]
        );
        $id = Session::get('user')->id;
        if($request->default == 1){
            DB::table('address')->where('user_id', $id)->update(['isDefault' => 0]);
            DB::table('address')->insert([
                'user_id' => $id,
                'address' => $request->address,
                'isDefault' => 1,
            ]);
        }else{
            DB::table('address')->insert([
                'user_id' => $id,
                'address' => $request->address,
                'isDefault' => 0,
            ]);
        }
        return redirect()->back()->with('success', 'Thêm địa chỉ thành công');
    }
    public function deleteAddress($id)
    {
        // $this->AuthLogin();
        DB::table('address')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Đã xóa địa chỉ');
    }
    public function setDefault($id)
    {
        // $this->AuthLogin();
        DB::table('address')->where('user_id', Session::get('user')->id)
            ->update(['isDefault' => 0]);
        DB::table('address')->where('user_id', Session::get('user')->id)
            ->where('id', $id)->update(['isDefault' => 1]);
        return redirect()->back()->with('success', 'Đã thiết lập làm địa chỉ mặc định');
    }
    public function editAddress($id)
    {
        // $this->AuthLogin();
        $address = DB::table('address')->where('id', $id)->first();
        return view('frontend.user.updateAddress', compact('address'));
    }
    public function updateAddress(Request $request, $id)
    {
        // $this->AuthLogin();
        $this->validate(
            $request,
            [
                'address' => 'required|unique:address,address,' . $id,
            ],
            [
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'address.unique' => 'Địa chỉ đã tồn tại',
            ]
        );
        DB::table('address')->where('id', $id)->update([
            'address' => $request->address,
        ]);
        return redirect()->route('address')->with('success', 'Cập nhật địa chỉ thành công');
    }
    public function coupon()
    {
        // $this->AuthLogin();
        $id = Session::get('user')->id;
        $vc = DB::table('coupons_user')
            ->join('coupons', 'coupons_user.cou_id', '=', 'coupons.cou_id')
            ->where('user_id', $id)->get();
        return view('frontend.user.voucher', compact('vc'));
    }
    public function forgotPassword()
    {
        return view('frontend.user.forgotPassword');
    }
    public function postForgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ], [
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
        ]);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $token = Str::random(60);
        if ($user) {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
            Mail::send('frontend.user.password', ['token' => $token], function ($message) use ($email) {
                $message->to($email, 'Khách hàng')->subject('Lấy lại mật khẩu');
            });
            return redirect()->back()->with('success', 'Chúng tôi đã gửi một email với hướng dẫn để lấy lại mật khẩu');
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại');
        }
    }
    public function resetPassword($token)
    {
        $check = DB::table('password_resets')->where('token', $token)->first();
        if ($check) {
            $email = $check->email;
            $user = User::where('email', $email)->first();
            if ($user) {
                return view('frontend.user.resetPassword', compact('token'));
            } else {
                return redirect()->route('home')->with('error', 'Email không tồn tại');
            }
        } else {
            return redirect()->route('home')->with('error', 'Token không tồn tại');
        }
    }
    public function postResetPassword(Request $request, $token)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required|min:8|max:20',
                'Repassword' => 'required|same:password',
            ],
            [
                'email' => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
                'password.max' => 'Mật khẩu chỉ được tối đa 20 ký tự',
                'Repassword.required' => 'Bạn chưa nhập lại mật khẩu',
                'Repassword.same' => 'Mật khẩu nhập lại chưa khớp',
            ]
        );
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            DB::table('password_resets')->where('token', $token)->delete();
            $user->password = Hash::make($password);
            $user->save();
            return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công');
        } else {
            return redirect()->route('home')->with('error', 'Email không tồn tại');
        }
    }
}
