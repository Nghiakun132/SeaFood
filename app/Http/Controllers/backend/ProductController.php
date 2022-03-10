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
use Illuminate\Support\Facades\Artisan;
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

        $ip = DB::table('import_products')->insertGetId([
            'ip_admin_id' => Session('admins')->id,
            'ip_total' => $request->pro_price * $request->pro_qty,
            'ip_status' => "Thêm mới",
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);
        DB::table('import_product_details')->insert([
            'ipd_import_product_id' => $ip,
            'ipd_product_id' => $productLatest->pro_id,
            'ipd_quantity' =>   $request->pro_qty,
            'ipd_price' =>  $request->pro_price,
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);
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
                    'pro_name' => 'required|unique:products,pro_name,' . $qty->pro_id . ',pro_id',
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
                    'pro_name' => 'required|unique:products,pro_name,' . $qty->pro_id . ',pro_id',
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
        $import = DB::table('import_products')
            ->join('admins', 'import_products.ip_admin_id', '=', 'admins.id')
            ->select('import_products.*', 'admins.name')
            ->orderBy('ip_id', 'desc')->get();
        return view('backend.import.index', compact('import'));
    }
    public function import_detail($id)
    {
        $this->AuthLogin();
        $import = DB::table('import_products')
            ->join('admins', 'import_products.ip_admin_id', '=', 'admins.id')
            ->join('import_product_details', 'import_products.ip_id', '=', 'import_product_details.ipd_import_product_id')
            ->join('products', 'import_product_details.ipd_product_id', '=', 'products.pro_id')
            ->select('import_products.*', 'admins.name', 'import_product_details.*', 'products.pro_name')
            ->where('ipd_import_product_id', $id)->first();
        return view('backend.import.detail', compact('import'));
    }
    public function sales()
    {
        $sales = DB::table('sales')->get();
        $countSales = DB::table('sales')->where('sale_status', 1)->count();
        $productsV2 = DB::table('sale_details')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'sale_details.product_id', '=', 'products.pro_id')
            ->where('sale_status', 1)
            ->get();
        return view('backend.sales.index', compact('sales', 'countSales', 'productsV2'));
    }
    public function store_sales(Request $request)
    {
        $this->validate(
            $request,
            [
                'time_start' => 'required',
                'time_end' => 'required',
                'sale_percent' => 'required',
            ],
            [
                'time_start.required' => 'Bạn chưa nhập thời gian bắt đầu',
                'time_end.required' => 'Bạn chưa nhập thời gian kết thúc',
                'sale_percent.required' => 'Bạn chưa nhập phần trăm khuyến mãi',
            ]
        );
        //format thời gian
        $time_start = Carbon::parse($request->time_start)->format('Y/m/d H:i:s');
        $time_end = Carbon::parse($request->time_end)->format('Y/m/d H:i:s');
        if ($time_start > $time_end) {
            return redirect()->back()->with('error', 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc');
        } else {
            DB::table('sales')->insert([
                'time_start' => $time_start,
                'time_end' => $time_end,
                'sale_percent' => $request->sale_percent / 100,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }
        return redirect()->back()->with('success', 'Thêm khuyến mãi thành công');
    }
    public function destroy_sales($id)
    {
        DB::table('sales')->where('id', $id)->delete();
        return redirect()->route('admin.sales')->with('success', 'Xóa khuyến mãi thành công');
    }
    public function changeStatus_sales($id)
    {
        $sale = DB::table('sales')->where('id', $id)->first();
        $details = DB::table('sale_details')->where('sale_id', $id)->get();
        foreach ($details as $detail) {
            DB::table('products')->where('pro_id', $detail->product_id)->update([
                'pro_sale' => 0,
            ]);
        }
        if ($sale->sale_status == 1) {
            DB::table('sales')->where('id', $id)->update([
                'sale_status' => 0,
            ]);
        }
        return redirect()->route('admin.sales')->with('success', 'Thay đổi trạng thái thành công');
    }
    public function addProduct($id)
    {
        $products = DB::table('products')->get();

        return view('backend.sales.addProduct', compact('products', 'id'));
    }

    public function add_product_post(Request $request, $id)
    {
        $sale_percent = DB::table('sales')->where('sale_status', 1)->first();
        foreach ($request->check as $check) {
            $checkv2[] = (int)$check;
        }
        foreach ($checkv2 as $db) {
            $checkExist = DB::table('sale_details')->where('product_id', $db)->where('sale_id', $id)->first();
            if ($checkExist) {
                continue;
            } else {
                DB::table('sale_details')->insert([
                    'sale_id' => $id,
                    'product_id' => $db,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                ]);
                DB::table('products')->where('pro_id', $db)->update([
                    'pro_sale' => $sale_percent->sale_percent,
                ]);
            }
        }
        return redirect()->route('admin.sales')->with('success', 'Thêm sản phẩm khuyến mãi thành công');
    }
    public function checkExpired()
    {
        Artisan::call('check:Discount');
        return redirect()->back()->with('success', 'Kiểm tra hết hạn thành công');
    }
}
