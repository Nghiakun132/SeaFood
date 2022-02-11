<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class OrderComposer
{
    public function compose(View $view)
    {
        $noti = DB::table('notifications')->orderBy('id','desc')->where('role',1)->get();
        $count = count(DB::table('notifications')->where('read',0)->where('role',1)->get());

        $view->with('countNoti', $count);
        $view->with('noti', $noti);
    }
}
