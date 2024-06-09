<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // ミドルウェアでゲストと登録済みの認証ユーザーのアクセス可否を設定
    public function __construct()
    {
        $this->middleware('guest')->except('login'); //変更
    }


    public function login(Request $request)
    {
        if ($request->isMethod('post')) { //post送信の確認

            // 入力データの取得
            $data = $request->only('mail', 'password');
            if (Auth::attempt($data)) { //ユーザーの認証
                return redirect('/top'); //認証成功でtopへ
            }
        }
        return view("auth.login"); //認証失敗でログインページへ
    }

    // ログアウトの処理実行
    public function logout()
    {
        Auth::logout(); //ユーザーのログアウト
        return redirect()->route("login"); //ログインページへリダイレクト
    }
}
