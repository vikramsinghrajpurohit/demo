<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $fillable = ['user_id', 'title','subtitle','image','status','details'];

    public function reviews()
    {
        return $this->hasMany('App\Models\Review','post_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
