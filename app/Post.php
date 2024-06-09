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


    // 投稿の所有者のリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
