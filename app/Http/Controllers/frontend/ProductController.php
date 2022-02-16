<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\image_products;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class ProductController extends Controller
{
    public function AuthLogin()
    {
        $user = Session::get('user');
        if ($user) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->send();
        }
    }
    public function index($slug)
    {
        $product = products::where('pro_slug', $slug)->first();
        $cate = categories::where('c_id', $product->pro_category_id)->first();
        DB::table('products')->where('pro_id', $product->pro_id)->update([
            'pro_view' => $product->pro_view + 1,
        ]);
        $productRelated = products::where('pro_status', 0)->where('pro_category_id', $product->pro_category_id)->where('pro_id', '<>', $product->pro_id)->get();
        $images = image_products::where('img_product_id', $product->pro_id)->get();
        $popularProducts = products::where('pro_status', 0)->orderBy('pro_view', 'desc')->limit(6)->get();
        return view('frontend.detail.index', compact('product', 'images', 'productRelated', 'cate', 'popularProducts'));
    }

    public function wishList()
    {
        $this->AuthLogin();
        $products = DB::table('wishlist')
            ->join('products', 'products.pro_id', '=', 'wishlist.w_product_id')
            ->where('w_user_id', Session::get('user')->id)->paginate(10);
        return view('frontend.wishlist.index', compact('products'));
    }

    public function addWishlist($id)
    {
        $this->AuthLogin();
        $check = DB::table('wishlist')->where('w_user_id', Session::get('user')->id)->where('w_product_id', $id)->first();
        if ($check == null) {
            DB::table('wishlist')->insert([
                'w_user_id' => Session::get('user')->id,
                'w_product_id' => $id
            ]);
            return Redirect()->back()->with('success', 'Thêm sản phẩm vào danh sách yêu thích thành công');
        } else {
            return Redirect()->back()->with('error', 'Sản phẩm đã tồn tại trong danh sách yêu thích');
        }
    }
    public function deleteWishlist($id)
    {
        $this->AuthLogin();
        DB::table('wishlist')->where('w_user_id', Session::get('user')->id)->where('w_product_id', $id)->delete();
        return Redirect()->back()->with('success', 'Xóa sản phẩm khỏi danh sách yêu thích thành công');
    }
    public function deleteAllWishlist(){
        $this->AuthLogin();
        DB::table('wishlist')->where('w_user_id', Session::get('user')->id)->delete();
        return Redirect()->back()->with('success', 'Xóa tất cả sản phẩm khỏi danh sách yêu thích thành công');
    }
}
