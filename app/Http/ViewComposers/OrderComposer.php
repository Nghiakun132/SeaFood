<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class OrderComposer
{
    public function compose(View $view)
    {
        $noti = DB::table('notifications')->orderBy('id','desc')->where('role',null)->get();
        $notiLimit = DB::table('notifications')->orderBy('id','desc')->where('role',null)->where('read',0)->limit(3)->get();
        $count = count(DB::table('notifications')->where('read',0)->where('role',null)->get());
        $view->with('countNoti', $count);
        $view->with('noti', $noti);
        $view->with('notiLimit', $notiLimit);
    }
}
