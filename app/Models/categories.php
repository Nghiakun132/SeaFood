<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'c_id';
    protected $fillable = ['c_name','c_slug','c_status','created_at','updated_at'];
}
