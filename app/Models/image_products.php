<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_products extends Model
{
    use HasFactory;
    protected $table = 'images_product';
    protected $fillable = ['img_name', 'img_product_id'];
    protected $primaryKey = 'img_id';
    public $timestamps = false;
}
