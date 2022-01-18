<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admins extends Model
{
    use HasFactory;
    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'password','phone', 'avatar','role', 'email_verified_at', 'remember_token', 'created_at', 'updated_at'];
}
