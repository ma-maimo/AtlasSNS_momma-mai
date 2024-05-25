<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Post;
use App\Follow;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    //追加🌼

    // 🌼
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('users.search', compact('users'));
    }

    // public function follow(Request $request)
    // {
    //     $following_id = $request->following_id;
    //     $followed_id = $request->followed_id;

    //     //ログインユーザーが対象のユーザーをフォローしているか？
    //     $isFollow = (bool) Follow::where('id', Auth::user()->id)->where('following_id', $following_id)->first();

    //     if ($isFollow) {
    //         $nofollow = Follow::where('id', Auth::user()->id)->where('following_id', $following_id);
    //         $nofollow->delete();
    //     } else {
    //         $follow = new follow();
    //         $follow->id = Auth::user()->id;
    //         $follow->following_id = $following_id;
    //         $follow->followed_id = $followed_id;
    //         $follow->save();
    //     }
    //     return back();
    // }

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

    // 検索ワード
    // public function searchWord(Request $request)
    // {
    //     $keyword = $request->input('keyword');
    //     $query = User::query();

    //     if (!empty($keyword)) {
    //         $query->orwhere('username', 'like', '%')->get();
    //     }

    //     // 全件取得
    //     $data = $query->orderBy('created_at', 'desc')->paginate(5);
    //     return view('users.search')->with('data', $data)->with('keyword', $keyword);
    // }

    // ユーザー表示
    // public function allUsers()
    // {
    //     $allUsers = auth()->user()->allUsers()->get();
    //     return view('users.allUsers', ['allUsers' => $allUsers]);
    // }
}
