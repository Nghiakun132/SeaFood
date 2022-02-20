<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
class UserController extends Controller
{
    public function AuthLogin(){
        $admin = Session::get('admins');
        if($admin){
            return redirect()->route('home');
        }else{
            return redirect()->route('login')->send();
        }
    }
    public function index(){
        $this->AuthLogin();
        $users = User   ::all();
        return view('backend.users.index', compact('users'));
    }
}
