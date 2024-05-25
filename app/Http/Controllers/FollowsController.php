<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\Follow;



class FollowsController extends Controller
{
    public function followList() //フォローリスト
    {
        return view('follows.followList');
    }
    public function followerList() //フォロワーリスト
    {
        return view('follows.followerList');
    }


    public function index() //ユーザー取得
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('follows.followList', compact('users'));
    }

    //フォロー解除機能
    public function unfollow(Request $request)
    {
        $following_id = $request->input('followed_id'); //search.bladeのuser_idを受け取る
        $user = User::FindOrFail($following_id); //データ取得
        Auth()->user()->follows()->detach($user->id);
        return redirect()->back();
    }

    //フォロー機能
    public function follow(Request $request)
    {
        $following_id = $request->input('followed_id'); //search.bladeのuser_idを受け取る
        $user = User::FindOrFail($following_id); //データ取得
        Auth()->user()->follows()->attach($user->id); //user.phpのfollowersメソッド使用
        return redirect()->back();
    }

    // フォローリスト
    public function followUsers()
    {
        $followUsers = auth()->user()->follows()->get();
        return view('follows.followList', ['followUsers' => $followUsers]);
    }

    // フォロワーリスト
    public function followersUsers()
    {
        $followersUsers = auth()->user()->followers()->get();
        return view('follows.followerList', ['followersUsers' => $followersUsers]);
    }
}
