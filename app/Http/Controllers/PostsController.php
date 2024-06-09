<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Post;


class PostsController extends Controller
{
    //投稿の一覧取得、表示
    public function index(Post $post) //Postモデルのインスタンスを取得する引数$post
    {
        $user_id = Auth::id(); //ログインユーザーの取得
        // ログインしているユーザーがフォローしているユーザーのIDを取得
        $following_user = Auth::user()->follows()->pluck('followed_id');
        // フォローしているユーザーとログインしているユーザーの投稿を取得
        $posts = Post::with('user')
            ->whereIn('user_id', $following_user)
            ->orwhere('user_id', $user_id) //かつフォローしているユーザー
            ->get(); //取得

        // 新しい順にソート
        $posts = $posts->sortByDesc('updated_at');

        return view('posts.index', [ //取得した投稿をビューに渡す
            'posts' => $posts,
        ]);
    }


    // 投稿作成処理
    public function postCreate(Request $request)
    {
        $request->validate([ //投稿のバリデーション
            'post' => 'required|between:1,150',
        ]);

        // バリデーションが通った場合は、投稿内容とログインしているユーザーのIDを取得
        $post = $request->input('post');
        $user_id = Auth::user()->id;
        // dd($user_id);

        Post::create([ //postモデルで投稿をDBに登録
            'user_id' => $user_id,
            'post' => $post,
        ]);

        return redirect('/top'); //topページにリダイレクト
    }


    // 指定された投稿IDの投稿削除処理
    public function destroy($id)
    {
        Post::where('id', $id)->delete(); //指定されたIDに一致する投稿を検索、検索された投稿を削除
        return redirect('/top'); //topページにリダイレクト
    }


    //選択された投稿の表示（モーダル内）
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }


    // 投稿の編集処理
    public function update(Request $request)
    {
        // dd($id);
        // try {
        $request->validate([ //バリデーション
            'post' => 'required|between:1,150',
        ]);

        $post_id = $request->input('post_id'); //リクエストから投稿のID (post_id) を取得
        // dd($post_id);

        $new_post = Post::findOrFail($post_id); //投稿IDで更新する投稿をDBから探す
        // dd($new_post);
        $new_post->post = $request->post; //新しい投稿をリクエストから取得、見つけた投稿のpostプロパティに代入
        $new_post->save(); //変更を保存

        return redirect('/top'); //topページにリダイレクト
    }
    // } catch (\Exception $e) {
    // エラーが発生した場合、エラーメッセージを表示してデバッグする
    // dd($e->getMessage());
    // }

}
