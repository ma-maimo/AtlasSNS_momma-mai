<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mail', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //ログインユーザーがフォローしているユーザーを取得する
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    // ログインユーザーをフォローしているユーザーを取得する
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }

    // ログインユーザーがフォローしているかどうかのif文
    public function isFollow($id) //search.bladeのidを受け取る
    {
        $isFollow = (bool) Auth::user()->follows()->where('followed_id', $id)->first();

        return $isFollow;
    }

    // ログインユーザーがフォローされているかどうかのif文
    public function isFollowers($id) //search.bladeのidを受け取る
    {
        $isFollowers = (bool) Auth::user()->followers()->where('following_id', $id)->first();

        return $isFollowers;
    }

    // フォロー数のカウント
    public function followsCounts()
    {
        $follows_count = Auth::user()->follows()->count(); // ログインしているユーザーのフォロワー数を取得する
        return view('users.login', ['follows_count' => $follows_count]); // ビューに変数 $follows_count を渡す
    }


    // ユーザーの投稿のリレーション
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
