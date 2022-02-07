<?php

namespace App\Http\ViewComposers;

use App\Models\cart;
// use Illuminate\View\View;
use Illuminate\Contracts\View\View;
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
            $view->with('count', 0);
            $view->with('view', 999);
        } else {
            $count = count($this->cart->where('cart_user_id', Session::get('user')->id)->get());
            $view->with('view', 999);
            $view->with('count', $count);
        }
    }
}
