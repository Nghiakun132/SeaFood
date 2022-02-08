<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class SearchComposer
{
    public function compose(View $view)
    {
        $view->with('search', $search);
    }
}
