<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class FollowsController extends Controller
{
    // フォローリストの表示
    public function followList()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get(); //ログインユーザー以外のすべてのユーザーを取得
        // dd($users);
        // ログインユーザーがフォローしているユーザーを取得
        $followUsers = User::whereHas('followers', function ($query) {
            $query->where('following_id', Auth::id());
        })->get();
        // dd($followerUsers);

        // フォローユーザーの投稿を収集
        $posts = collect(); //$posts変数を初期化、その後のループでフォローユーザーの投稿を収集するために使用
        //フォローユーザーごとに、それぞれのユーザーの投稿を取得し、$postsコレクションに追加し繰り返し処理
        foreach ($followUsers as $user) { //現在のユーザーがフォローしているユーザーのリスト
            foreach ($user->posts as $post) { //各ユーザーの投稿を取得しフォローユーザーごとに処理を行う
                $posts->push($post); //取得した投稿$postを$postsコレクションに追加
            }
        }

        // 新しい順にソート
        $posts = $posts->sortByDesc('created_at');

        //followList ビューに、取得した投稿とフォローユーザーを渡して表示
        return view('follows.followList', compact('posts', 'followUsers'));
    }


    // フォロワーリストの表示
    public function followerList()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get(); //ログインユーザー以外のすべてのユーザーを取得
        // dd($users);

        // 現在のユーザーをフォローしているユーザー（フォロワー）を取得
        $followerUsers = User::whereHas('follows', function ($query) {
            $query->where('followed_id', Auth::id());
        })->get();
        // dd($followUsers);

        // フォロワーユーザーの投稿を収集
        $posts = collect(); //$posts変数を初期化、その後のループでフォロワーユーザーの投稿を収集するために使用
        //フォロワーユーザーごとに、それぞれのユーザーの投稿を取得し、$postsコレクションに追加し繰り返し処理
        foreach ($followerUsers as $user) { //現在のユーザーをフォローしている(フォロワー)ユーザーのリスト
            foreach ($user->posts as $post) { //各ユーザーの投稿を取得しフォロワーユーザーごとに処理を行う
                $posts->push($post); //取得した投稿$postを$postsコレクションに追加
            }
        }

        // 新しい順にソート
        $posts = $posts->sortByDesc('updated_at');

        //followerList ビューに、取得した投稿とフォローユーザーを渡して表示
        return view('follows.followerList', compact('posts', 'followerUsers'));
    }


    //フォロー解除機能
    public function unfollow(Request $request)
    {
        // フォロー解除するユーザーのIDを取得
        $followed_id = $request->input('followed_id');
        // dd($followed_id);
        // フォロー解除するユーザーをDBから取得
        $user = User::FindOrFail($followed_id);
        // 認証されたユーザーのフォロー関係から、対象のユーザーを削除
        Auth()->user()->follows()->detach($user->id);

        // リダイレクト先の判定
        if ($request->has('redirect_to_search')) {
            return redirect('/search'); // 検索ページからのリクエストの場合、検索ページにリダイレクト
        }
        return redirect()->back(); // デフォルトのリダイレクト先（元のページ）
    }


    //フォロー機能
    public function follow(Request $request)
    {
        // フォローするユーザーのIDを取得
        $followed_id = $request->input('followed_id');
        // dd($followed_id);
        // フォローするユーザーをデータベースから取得
        $user = User::FindOrFail($followed_id);
        // dd($user);
        // 認証されたユーザーのフォロー関係に対象のユーザーを追加
        Auth()->user()->follows()->attach($user->id);
        // リダイレクト先の判定
        if ($request->has('redirect_to_search')) {
            return redirect('/search'); // 検索ページからのリクエストの場合、検索ページにリダイレクト
        }

        // デフォルトのリダイレクト先（元のページ）
        return redirect()->back();
    }
}
