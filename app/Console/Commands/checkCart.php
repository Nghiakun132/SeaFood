<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class checkCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xử lý những sản phẩm tồn tại trong giỏ hàng quá 10 ngày';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $cart = DB::table('cart')->get();
        // $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        // foreach ($cart as $key => $value) {
        //     if ((strtotime($now) - strtotime($value->created_at))  > 14400) {
        //         //cap nhap quantity
        //         $pro_qty = DB::table('products')->where('pro_id', $value->cart_product_id)->first();
        //         DB::table('products')->where('pro_id', $value->cart_product_id)->update(
        //             ['pro_qty' => $pro_qty->pro_qty + $value->cart_product_quantity]
        //         );
        //         DB::table('cart')->where('cart_id', $value->cart_id)->delete();
        //     }
        // }
    }
}
