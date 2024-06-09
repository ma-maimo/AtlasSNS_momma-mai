<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{
    // ユーザー検索画面を表示
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get(); //ログインユーザー以外の全ユーザーの取得
        return view('users.search', compact('users')); //検索ページに$user変数を連想配列で渡す
    }


    // 検索処理
    public function searchView(Request $request)
    {
        $keyword = $request->input('keyword'); //検索ワードの取得
        // dd($keyword);
        $query = User::query(); //ユーザー名に検索ワードが含まれているユーザーを検索

        if (isset($keyword)) { //検索ワードが存在する場合
            //検索クエリでユーザー名が検索キーワードを含むかどうか
            $query->where('username', 'like', '%' . $keyword . '%')->get();
            //検索結果に当てはまるユーザーを全件取得、作成日時で降順、20件ずつのページネーション
            $users = $query->orderBy('created_at', 'desc')->paginate(20);
        } else { //検索キーワードが存在しない場合
            // すべてのユーザーを作成日時の降順で取得、20件ずつのページネーション
            $users = $query->orderBy('created_at', 'desc')->paginate(20);
        }
        // dd($data);
        // 検索キーワード、ユーザーの検索結果、クエリ、およびリダイレクトフラグをビューに渡す
        return view('users.search', [
            'keyword' => $keyword,
            'users' => $users,
            'query' => $query,
            'redirect_to_search' => true,
        ]);
    }


    //ログインユーザーのプロフィール編集画面表示
    public function profile()
    {
        $user = Auth::user(); //ログインユーザーの取得
        // dd($user);
        return view('users.profile', compact('user')); //ビューに$user変数を渡す
    }


    // プロフィール編集機能
    public function profileUpdate(Request $request)
    {
        $user = Auth::user(); //ログインユーザーの情報取得
        // dd($user);
        $request->validate([ //バリデーション
            'username' => 'required|between:2,12',
            // usersテーブル内でメースアドレスがユニーク、メールアドレスが他のユーザーと重複していないか
            'mail' => 'required|email|between:5,40|unique:users,mail,' . auth()->id(),
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|between:8,20|confirmed:password',
            'bio' => 'nullable|max:150',
            'images' => 'nullable|mimes:jpg,png,bmp,gif,svg',
        ]);

        // パスワードの入力がある場合のみ更新
        if ($request->filled('password')) { //パスワード入力があるか
            //Hash::make()は、渡された文字列をセキュリティハッシュ化、ユーザーモデルの password 属性に設定
            $user->password = Hash::make($request->input('password'));
        }

        // プロフィール画像のアップロード処理
        if ($request->hasFile('images')) { //ファイルがアップロードされたかどうか
            if ($user->images) { //ユーザーが既に画像を持っているかどうか
                Storage::delete('public/images/' . $user->images); // 古い画像が存在する場合は削除
            }

            // 新しい画像を保存
            $image = $request->file('images'); //'images' という名前のファイルを取得
            $imageName = time() . '.' . $image->getClientOriginalExtension(); //アップロードされたファイルの拡張子を取得
            $image->storeAs('public/images', $imageName); //現在時間＋取得したファイルの拡張子で重複防ぎ、public/imageに保存
            $user->images = $imageName; //ユーザーのモデルの images プロパティに、保存された画像ファイルの名前を代入、DB保存
        }

        // ユーザー情報の取得、更新
        $user->username = $request->input('username');
        $user->mail = $request->input('mail');
        $user->bio = $request->input('bio');
        $user->save(); //ユーザーモデルの変更をDBに保存

        return redirect('/top'); //topページにリダイレクト
    }


    // 他のユーザーのプロフィール
    public function otherProfile(Request $request, $id)
    {
        //idパラメーターで指定されたユーザー情報をDBから取得
        $user = User::with('posts')->findOrFail($id);
        // 指定されたユーザーの投稿を取得
        $user_posts = Post::where('user_id', $id)->latest()->get();
        // dd($user, $user_posts);

        // 他ユーザーのプロフィールページへ値を渡す
        return view('users.otherProfile', [
            'user' => $user,
            'user_posts' => $user_posts,
            'redirect_to_search' => $request->input('redirect_to_search', false),
        ]);
    }
}
