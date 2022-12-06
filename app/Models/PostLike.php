<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $table = 'postLike';
    protected $fillable = ['user_id', 'post_id'];
}
