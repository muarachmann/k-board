<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicAccessToken extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['token', 'expires_at', 'last_used_at'];
}
