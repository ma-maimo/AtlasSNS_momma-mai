<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Post;
use App\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('users.search', compact('users'));
    }

    public function profile()
    {
        return view('users.profile');
    }

    // ユーザー一覧取得
    public function search(Request $request)
    {
        // $query = $request->input('query');
        // $users = User::where('username', 'LIKE', "%{$query}%")->get();

        $users = User::paginate(20);

        return view('users.search')->with('users', $users);
        // return view('users.search');
    }

    // 検索処理
    public function searchView(Request $request)
    {
        // $users = User::paginate(20);
        $keyword = $request->input('keyword');
        // dd($keyword);
        $query = User::query();

        if (isset($keyword)) {
            $query->where('username', 'like', '%' . $keyword . '%')->get();
            // 全件取得
            $users = $query->orderBy('created_at', 'desc')->paginate(5);
        } else {
            // $users = User::paginate(20);
            $users = $query->orderBy('created_at', 'desc')->paginate(20);
        }

        // dd($data);
        return view('users.search')->with('keyword', $keyword)->with('users', $users)->with('query', $query);
    }


    // プロフィール編集機能
    public function edit()
    {
        $user = Auth::user();
        // dd($user);
        return view('users.profile', compact('user'));
    }

    public function update(Request $request)
    {
        // dd('aaaaa');
        $user = Auth::user();
        // dd($user);
        $request->validate([
            'username' => 'required|between:2,12',
            'mail' => 'required|email|unique:users,mail|between:5,40',
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|between:8,20|confirmed:password',
            'bio' => 'nullable|max:150',
            'images' => 'nullable|mimes:jpg,png,bmp,gif,svg',
        ]);


        // パスワードの入力がある場合のみ更新
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // プロフィール画像のアップロード処理
        if ($request->hasFile('images')) {
            // 古い画像が存在する場合は削除
            if ($user->images) {
                Storage::delete('public/images/' . $user->images);
            }

            // 新しい画像を保存
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); //時間＋ファイル名で重複防ぐ
            $image->storeAs('public/images', $imageName);
            $user->images = $imageName;
        }

        // ユーザー情報の更新
        $user->username = $request->input('username');
        $user->mail = $request->input('mail');
        // $user->password = $request->input('password');
        $user->bio = $request->input('bio');
        // $user->images = $request->file('images');
        $user->save();

        return redirect()->route('/top', $user->id)->with('success', 'プロフィールが更新されました。');
    }
}

    // public function update(Request $request)
    // {
    //     // 1つ目の処理
    //     $id = $request->input('id');
    //     $username = $request->input('username');
    //     $mail = $request->input('mail');
    //     $password = $request->input('password');
    //     $bio = $request->input('bio');
    //     $images = $request->input('images');
    //     // 2つ目の処理
    //     Book::where('id', $id)->update([
    //           'title' => $up_title,
    //           'price' => $up_price
    //     ]);
    //     // 3つ目の処理
    //     return redirect('/index');
    // }
