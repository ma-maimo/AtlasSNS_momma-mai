<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // タイムラインのテーブル作成
    protected $fillable = [
        'user_id',
        'post',
    ];
}
