<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class import_product extends Model
{
    use HasFactory;
    protected $table = 'import_products';
    protected $fillable = ['ip_admin_id', 'ip_total_price', 'created_at', 'updated_at'];
    protected $primaryKey = 'ip_id';
}
