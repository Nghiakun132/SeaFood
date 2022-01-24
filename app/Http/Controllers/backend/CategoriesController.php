<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\categories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;

class CategoriesController extends Controller
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
    public function __construct(categories $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $this->AuthLogin();
        $categories = $this->categories->all();
        return view('backend.categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->AuthLogin();
        $this->validate($request, [
            'c_name' => 'required|unique:categories,c_name',
        ], [
            'c_name.required' => 'Bạn chưa nhập tên danh mục',
            'c_name.unique' => 'Tên danh mục đã tồn tại',
        ]);
        $this->categories->c_name = $request->c_name;
        $this->categories->c_slug = Str::slug($request->c_name);
        $this->categories->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $this->categories->save();
        return redirect()->back()->with('cate_success', 'Thêm danh mục thành công');
    }
    public function edit($id)
    {
        $this->AuthLogin();
        $categories = $this->categories->where('c_id', $id)->first();
        return view('backend.categories.edit', compact('categories'));
    }
    public function update(Request $request, $id)
    {
        $this->AuthLogin();
        $this->validate($request, [
            'c_name' => 'required'
        ], [
            'c_name.required' => 'Bạn chưa nhập tên danh mục',
        ]);
        $this->categories->where('c_id', $id)->update([
            'c_name' => $request->c_name,
            'c_slug' => Str::slug($request->c_name),
            'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);
        return redirect()->route('admin.categories')->with('cate_success', 'Sửa danh mục thành công');
    }
    public function destroy($id)
    {
        $this->AuthLogin();
        $this->categories->where('c_id', $id)->delete();
        return redirect()->back()->with('cate_success', 'Xóa danh mục thành công');
    }
    public function changeStatus($id)
    {
        $this->AuthLogin();
        $categories = $this->categories->where('c_id', $id)->first();
        if ($categories->c_status == 1) {
            $this->categories->where('c_id', $id)->update([
                'c_status' => 0,
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        } else {
            $this->categories->where('c_id', $id)->update([
                'c_status' => 1,
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }
        return redirect()->back();
    }
}
