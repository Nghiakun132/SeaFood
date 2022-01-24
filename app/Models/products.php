<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'pro_id';
    protected $fillable = [
        'pro_name',
        'pro_slug',
        'pro_price',
        'pro_sale',
        'pro_description',
        'pro_avatar',
        'pro_qty',
        'pro_unit',
        'pro_content',
        'pro_category_id',
        'created_at',
        'updated_at',
    ];
}
