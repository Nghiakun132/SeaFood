<?php

namespace App\Http\ViewComposers;

use App\Models\cart;
use Carbon\Carbon;
// use Illuminate\View\View;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Session;

class ViewComposer
{
    public function __construct(cart $cart)
    {
        $this->cart = $cart;
    }

    public function compose(View $view)
    {
        if (Session::get('user') == null) {
            $notification = DB::table('notifications')->where('user_id',0)->get();
            $countNotification = count($notification);
            $view->with('count', 0);
            $view->with('view', 999);
            $view->with('countNotification', $countNotification);
            $view->with('notification', $notification);
        } else {
            $count = count($this->cart->where('cart_user_id', Session::get('user')->id)->get());
            $notification = DB::table('notifications')->where('user_id', Session::get('user')->id)->orderby('id','desc')->limit(3)->get();
            $countNotification = count(DB::table('notifications')->where('user_id', Session::get('user')->id)->where('read',0)->get());
            // $wishlist = DB::table('wishlist')->where('w_user_id', Session::get('user')->id)->get();
            // $view->with('view', count($wishlist));
            $view->with('count', $count);
            $view->with('notification', $notification);
            $view->with('countNotification', $countNotification);
        }
    }
}
