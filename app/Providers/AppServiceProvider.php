<?php

namespace App\Providers;

use App\Models\cart;
use App\Models\categories;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try{
            $category = categories::all();

        }catch(Exception $e){

        }
        View::share('categoryGlobal', $category);
    }
}
