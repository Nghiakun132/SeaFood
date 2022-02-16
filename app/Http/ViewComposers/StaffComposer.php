<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class StaffComposer
{
    public function compose(View $view)
    {
        $staffs = DB::table('admins')->get();
        $view->with('staffs', $staffs);
    }
}
