<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CommentController extends Controller
{
    public function AuthLogin()
    {
        $admin = Session::get('admins');
        if ($admin) {
            return redirect()->back();
        } else {
            return redirect()->route('admin.login')->send();
        }
    }
    public function index()
    {
        // $this->AuthLogin();
        $comments = DB::table('comments')
            ->join('products', 'comments.cm_product_id', '=', 'products.pro_id')
            ->join('users', 'comments.cm_user_id', '=', 'users.id')
            ->select('comments.*', 'products.pro_avatar', 'users.name')
            ->orderBy('cm_id', 'DESC')->get();
        return view('backend.comment.index', compact('comments'));
    }
    public function destroy($id)
    {
        // $this->AuthLogin();
        DB::table('comments')->where('cm_id', $id)->delete();
        return redirect()->route('admin.comment')->with('success', 'Xóa thành công');
    }
    public function changeStatus($id)
    {
        // $this->AuthLogin();
        $comment = DB::table('comments')->where('cm_id', $id)->first();
        if ($comment->cm_status == 0) {
            DB::table('comments')->where('cm_id', $id)->update(['cm_status' => 1]);
        } elseif ($comment->cm_status == 1) {
            DB::table('comments')->where('cm_id', $id)->update(['cm_status' => 0]);
        }
        return redirect()->back();
    }
}
