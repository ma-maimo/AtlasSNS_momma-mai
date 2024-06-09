<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    // モデルのインスタンスを作成
    protected $fillable = ['following_id', 'followed_id'];

    // DBテーブルの関連付け
    protected $table = 'follows';

    // 特定のユーザーを除いた全てのユーザーをページネーション付きで取得
    public function getAllUsers(Int $id)
    {
        return $this->Where('id', '<>', $id)->paginate(5);
    }
}
