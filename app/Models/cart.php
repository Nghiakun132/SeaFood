<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $fillable = ['cart_id','cart_user_id', 'cart_product_name', 'cart_product_price', 'cart_product_quantity', 'cart_product_image','cart_voucher_code', 'created_at', 'updated_at'];
    protected $guarded = [];
}
