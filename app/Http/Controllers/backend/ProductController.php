<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\image_products;
use App\Models\import_product;
use App\Models\import_product_details;
use App\Models\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// View::share('site_settings', $this->cat);

class ProductController extends Controller
{
    public function AuthLogin()
    {
        $admins = session()->get('admins');
        if ($admins) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->send();
        }
    }
    public function __construct(products $products, categories $categories)
    {
        $this->products = $products;
        $this->categories = $categories;
    }

    public function index()
    {
        $this->AuthLogin();
        $products = $this->products->join('categories', 'products.pro_category_id', '=', 'categories.c_id')
            ->select('products.*', 'categories.c_name')->get();
        return view('backend.products.index', compact('products'));
    }
    public function create()
    {
        $this->AuthLogin();
        $categories = $this->categories->all();
        return view('backend.products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->AuthLogin();
        $this->validate($request, [
            'pro_name' => 'required|unique:products,pro_name',
            'pro_price' => 'required',
            'pro_sale' => 'required',
            'pro_description' => 'required',
            'pro_qty' => 'required',
            'pro_unit' => 'required',
            'pro_content' => 'required',
            'pro_category_id' => 'required',
            'pro_avatar' => 'required',
        ], [
            'pro_name.required' => 'Bạn chưa nhập tên sản phẩm',
            'pro_name.unique' => 'Tên sản phẩm đã tồn tại',
            'pro_price.required' => 'Bạn chưa nhập giá sản phẩm',
            'pro_sale.required' => 'Bạn chưa nhập giá khuyến mãi',
            'pro_description.required' => 'Bạn chưa nhập mô tả sản phẩm',
            'pro_qty.required' => 'Bạn chưa nhập số lượng sản phẩm',
            'pro_unit.required' => 'Bạn chưa nhập đơn vị tính',
            'pro_content.required' => 'Bạn chưa nhập nội dung sản phẩm',
            'pro_category_id.required' => 'Bạn chưa chọn danh mục sản phẩm',
            'pro_avatar.required' => 'Bạn chưa chọn ảnh sản phẩm',
        ]);
        $avatar = $request->file('pro_avatar');
        $product = new products();
        $product->pro_name = $request->pro_name;
        $product->pro_slug = Str::slug($request->pro_name);
        $product->pro_price = $request->pro_price;
        $product->pro_sale = ($request->pro_sale) / 100;
        $product->pro_description = $request->pro_description;
        $product->pro_content = $request->pro_content;
        $product->pro_unit = $request->pro_unit;
        $product->pro_qty = $request->pro_qty;
        $product->pro_category_id = $request->pro_category_id;
        $product->pro_avatar = $avatar[rand(0, count($avatar) - 1)]->getClientOriginalName();
        $product->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $product->save();
        $productLatest = $this->products->orderBy('pro_id', 'desc')->first();
        $imgs = array();
        foreach ($avatar as $file) {
            $img = new image_products();
            $img->img_product_id = $productLatest->pro_id;
            $name = $file->getClientOriginalName();
            $file->move('uploads/products', $name);
            $imgs[] = $name;
            $img->img_name = $name;
            $img->save();
        }
        $import = new import_product();
        $import->ip_admin_id = session()->get('admins')->id;
        $import->ip_product_name = $productLatest->pro_name;
        $import->ip_qty = $request->pro_qty;
        $import->ip_status = "Thêm mới";
        $import->ip_price = $request->pro_price;
        $import->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $import->save();
        return redirect()->route('admin.product')->with('success', 'Thêm sản phẩm thành công');
    }
    public function edit($id)
    {
        $this->AuthLogin();
        $categories = $this->categories->all();
        $product = $this->products->where('pro_id', $id)->first();
        return view('backend.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $this->AuthLogin();
        $qty = $this->products->where('pro_id', $id)->first();
        if ($request->pro_qty != $qty->pro_qty) {
            $this->validate(
                $request,
                [
                    'pro_name' => 'required|unique:products,pro_name,' . $qty->pro_id.',pro_id',
                    'pro_price' => 'required',
                    'pro_sale' => 'required',
                    'pro_description' => 'required',
                    'pro_qty' => 'required',
                    'pro_category_id' => 'required',
                ],
                [
                    'pro_name.required' => 'Bạn chưa nhập tên sản phẩm',
                    'pro_name.unique' => 'Tên sản phẩm đã tồn tại',
                    'pro_price.required' => 'Bạn chưa nhập giá sản phẩm',

                    'pro_sale.required' => 'Bạn chưa nhập giá khuyến mãi',
                    'pro_description.required' => 'Bạn chưa nhập mô tả sản phẩm',
                    'pro_qty.required' => 'Bạn chưa nhập số lượng sản phẩm',
                    'pro_category_id.required' => 'Bạn chưa chọn danh mục sản phẩm',
                ]
            );
            $product = $this->products->where('pro_id', $id)->first();
            $product->pro_name = $request->pro_name;
            $product->pro_slug = Str::slug($request->pro_name);
            $product->pro_price = $request->pro_price;
            $product->pro_sale = ($request->pro_sale) / 100;
            $product->pro_description = $request->pro_description;
            $product->pro_qty = $product->pro_qty + $request->pro_qty;
            $product->pro_content = $request->pro_content;
            $product->pro_unit = $request->pro_unit;
            $product->pro_category_id = $request->pro_category_id;
            $product->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $product->save();

            $import = new import_product();
            $import->ip_admin_id = session()->get('admins')->id;
            $import->ip_product_name = $qty->pro_name;
            $import->ip_qty = $request->pro_qty;
            $import->ip_status = "Cập nhật";
            $import->ip_price = $request->pro_price;
            $import->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $import->save();
            return redirect()->route('admin.product')->with('success', 'Sửa sản phẩm thành công');
        } else {
            $this->validate(
                $request,
                [
                    'pro_name' => 'required|unique:products,pro_name,' . $qty->pro_id.',pro_id',
                    'pro_price' => 'required',
                    'pro_sale' => 'required',
                    'pro_description' => 'required',
                    'pro_qty' => 'required',
                    'pro_category_id' => 'required',
                ],
                [
                    'pro_name.required' => 'Bạn chưa nhập tên sản phẩm',
                    'pro_name.unique' => 'Tên sản phẩm đã tồn tại',
                    'pro_price.required' => 'Bạn chưa nhập giá sản phẩm',
                    'pro_sale.required' => 'Bạn chưa nhập giá khuyến mãi',
                    'pro_description.required' => 'Bạn chưa nhập mô tả sản phẩm',
                    'pro_qty.required' => 'Bạn chưa nhập số lượng sản phẩm',
                    'pro_category_id.required' => 'Bạn chưa chọn danh mục sản phẩm',
                ]
            );
            $product = $this->products->where('pro_id', $id)->first();
            $product->pro_name = $request->pro_name;
            $product->pro_slug = Str::slug($request->pro_name);
            $product->pro_price = $request->pro_price;
            $product->pro_sale = ($request->pro_sale) / 100;
            $product->pro_description = $request->pro_description;
            $product->pro_content = $request->pro_content;
            $product->pro_unit = $request->pro_unit;
            $product->pro_qty = $request->pro_qty;
            $product->pro_category_id = $request->pro_category_id;
            $product->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $product->save();
            return redirect()->route('admin.product')->with('success', 'Sửa sản phẩm thành công');
        }
    }
    public function destroy($id)
    {
        $this->AuthLogin();
        $product = $this->products->where('pro_id', $id)->first();
        $product->delete();
        $image = image_products::where('img_product_id', $id)->get();
        foreach ($image as $img) {
            $path = public_path('uploads/products/' . $img->img_name);
            if (file_exists($path)) {
                unlink($path);
            }
            $img->delete();
        }

        return redirect()->route('admin.product')->with('success', 'Xóa sản phẩm thành công');
    }
    public function changeStatus($id)
    {
        $this->AuthLogin();
        $product = $this->products->where('pro_id', $id)->first();
        if ($product->pro_status == 1) {
            $product->pro_status = 0;
        } else {
            $product->pro_status = 1;
        }
        $product->save();
        return redirect()->route('admin.product')->with('success', 'Thay đổi trạng thái thành công');
    }
    public function import()
    {
        $this->AuthLogin();
        $import = import_product::orderBy('ip_id', 'DESC')->get();
        return view('backend.import.index', compact('import'));
    }
}
