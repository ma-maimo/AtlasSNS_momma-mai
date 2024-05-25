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

    // 🌼
    //現在のユーザーがフォローしているユーザーを取得する
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }

    // 現在のユーザーのフォロワーを取得
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    //フォローしているかどうかのif文
    public function isFollow($id) //search.bladeのidを受け取る
    {
        $isFollow = (bool) Auth::user()->follows()->where('following_id', $id)->first();

        return $isFollow;
    }

    //フォローされているかどうかのif文
    public function isFollowers($id) //search.bladeのidを受け取る
    {
        $isFollowers = (bool) Auth::user()->followers()->where('followed_id', $id)->first();

        return $isFollowers;
    }

    public function followsCounts()
    {
        $follows_count = Auth::user()->follows()->count(); // ログインしているユーザーのフォロワー数を取得する
        return view('users.login', ['follows_count' => $follows_count]); // ビューに変数 $follows_count を渡す
    }

    //全ユーザー取得
    // public function allUsers()
    // {

    //     $allUsers = Users::all();
    //     // 全てのレコードを取得
    //     $user = User::all();
    //     // モデル名は命名のルールとして頭文字が大文字になっています
    //     $allUsers = DB::table('sllUsers')->get();

    //     return view('users.allUsers')->with('allUsers', $allUsers);
    // }
}
