<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class checkDiscount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:Discount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra sản phẩm có chương trình khuyến mãi hay không';

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
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $expired = DB::table('sales')->where('sale_status', 1)->first();
        if ($expired) {
            if (strtotime($now) > strtotime($expired->time_end)) {
                $details = DB::table('sale_details')->where('sale_id', $expired->id)->get();
                foreach ($details as $detail) {
                    DB::table('products')->where('pro_id', $detail->product_id)->update([
                        'pro_sale' => 0,
                    ]);
                }
                DB::table('sales')->where('id', $expired->id)->update(['sale_status' => 0]);
            }
        }else{
            $this->info('Không có chương trình giảm giá nào');
        }
    }
}
