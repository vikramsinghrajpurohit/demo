<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $fillable = ['name', 'email', 'comment', 'post_id'];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
