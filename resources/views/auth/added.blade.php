@extends('layouts.logout')

@section('content')

<div id="clear">
  <p class="added_username">{{ session('username') }}さん</p>
  <p class="added_welcome">ようこそ！AtlasSNSへ！</p>
  <p class="added_text">ユーザー登録が完了しました。<br>
    早速ログインをしてみましょう！</p>

  <div class="added_login_button">
    <a href="/login">
      {{ Form::submit('ログイン画面へ') }}
    </a>
  </div>

</div>

@endsection
