<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    // 新規登録ページの表示
    public function registerView(request $request)
    {
        return view('auth.register');
    }

    // 新規登録の処理
    public function register(request $request)
    {
        if ($request->isMethod('post')) { //post送信の確認
            $validated = $request->validate([ //バリデーション
                'username' => 'required|between:2,12',
                'mail' => 'required|email|unique:users,mail|between:5,40',
                'password' => 'required|regex:/^[a-zA-Z0-9]+$/|between:8,20|confirmed:password',
            ]);

            // フォームデータの取得
            $username = $request->input('username');
            $mail = $request->input('mail');
            $password = $request->input('password');

            // Userモデルを使ってユーザーの作成
            User::create([
                'username' => $username,
                'mail' => $mail,
                'password' => bcrypt($password), //伏字
            ]);

            // sessionで登録名の表示
            $request->session()->put('username', $username);
            return redirect('added');
        }
    }

    // ユーザー登録完了ページの表示
    public function added()
    {
        return view('auth.added');
    }
}
