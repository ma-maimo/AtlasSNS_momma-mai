<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Post;


class PostsController extends Controller
{
    //表示
    public function index()
    {
        $user_id = Auth::id();
        $user_posts = Post::where('user_id', $user_id)->latest()->get();
        // $list = Post::latest()->get(); //新しい順に表示

        return view('posts.index', [ //リスト取得
            // 'list' => $list,
            'user_posts' => $user_posts,
        ]);
    }

    // 作成
    public function postCreate(Request $request)
    {
        $request->validate([ //投稿のバリデーション
            'post' => 'required|between:1,150',
        ]);

        $post = $request->input('post'); //リクエスト
        $user_id = Auth::user()->id;
        // dd($user_id);

        Post::create([ //投稿の登録
            'user_id' => $user_id,
            'post' => $post,
        ]);

        return redirect('/top');
    }


    // 削除
    public function destroy($id)
    {
        Post::where('id', $id)->delete();
        return redirect('/top');
    }


    //モーダルの選択した編集ポスト取得
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    // ポストの編集処理
    public function update(Request $request)
    {
        // dd($id);
        // try {
        $request->validate([
            'post' => 'required|between:1,150',
        ]);

        $post_id = $request->input('post_id');
        // dd($post_id);


        $new_post = Post::findOrFail($post_id);
        // dd($new_post);
        $new_post->post = $request->post;
        $new_post->save();

        return redirect('/top');
    }
    // } catch (\Exception $e) {
    // エラーが発生した場合、エラーメッセージを表示してデバッグする
    // dd($e->getMessage());
    // }

}
