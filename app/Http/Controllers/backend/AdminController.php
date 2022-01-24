<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admins;
use Illuminate\Http\Request;
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
}
