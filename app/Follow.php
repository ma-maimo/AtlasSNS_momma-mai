<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    //
    // 追加
    protected $fillable = ['following_id', 'followed_id'];

    protected $table = 'follows';

    public function getAllUsers(Int $id)
    {
        return $this->Where('id', '<>', $id)->paginate(5);
    }
}
