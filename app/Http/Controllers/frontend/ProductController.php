<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\image_products;
use App\Models\products;
use Carbon\Carbon;
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
        $comments = products::join('comments', 'products.pro_id', '=', 'comments.cm_product_id')
            ->join('users', 'users.id', '=', 'comments.cm_user_id')
            ->select('comments.*', 'users.name', 'users.avatar', 'users.type')
            ->where('products.pro_id', $product->pro_id)
            ->paginate(10);
        $countComments = count($comments);
        $star = DB::table('comments')->where('cm_product_id', $product->pro_id)->avg('cm_star');
        if (Session::get('user')) {
            $checkCart = DB::table('cart')->where('cart_product_id', $product->pro_id)
                ->where('cart_user_id', Session::get('user')->id)->first();
            if ($checkCart) {
                $checkValue = $checkCart->cart_product_quantity;
            } else {
                $checkValue = 0;
            }
        } else {
            $checkValue = 0;
        }
        return view('frontend.detail.index', compact('product', 'images', 'productRelated', 'cate', 'popularProducts', 'comments', 'countComments', 'star', 'checkValue'));
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
    public function deleteAllWishlist()
    {
        $this->AuthLogin();
        DB::table('wishlist')->where('w_user_id', Session::get('user')->id)->delete();
        return Redirect()->back()->with('success', 'Xóa tất cả sản phẩm khỏi danh sách yêu thích thành công');
    }

    public function comments(Request $request, $id)
    {
        $this->AuthLogin();
        $product = products::where('pro_id', $id)->first();
        $data = array();
        $data['cm_product_id'] = $id;
        $data['cm_user_id'] = Session::get('user')->id;
        $data['cm_star'] = $request->rating;
        $data['cm_content'] = $request->comment;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('comments')->insert($data);
        return Redirect()->back();
    }
}
