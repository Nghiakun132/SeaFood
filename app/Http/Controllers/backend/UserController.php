<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    public function AuthLogin()
    {
        $admin = Session::get('admins');
        if ($admin) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->send();
        }
    }
    public function index()
    {
        $this->AuthLogin();
        $users = User::all();
        return view('backend.users.index', compact('users'));
    }
    public function destroy($id)
    {
        $this->AuthLogin();
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
    public function block($id)
    {
        $this->AuthLogin();
        $user = User::find($id);
        if ($user->block == 1) {
            $user->block = 0;
            $user->save();
        } else {
            $user->block = 1;
            $user->save();
        }
        return redirect()->back();
    }
}
