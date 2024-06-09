@extends('layouts.logout')

@section('content')

<!-- バリデーションエラーメッセージ -->
@if ($errors->any())
<div class="register_error">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!-- 新規登録フォーム -->
{!! Form::open(['url' => '/register']) !!}
<div class="register_wrapper">

  <h2 class="register">新規ユーザー登録</h2>

  <ul class="login_username">
    <li class="form_label">{{ Form::label('ユーザー名') }}</li>
    <li>{{ Form::text('username',null,['class' => 'input']) }}</li>
  </ul>

  <ul class="login_mail">
    <li class="form_label">{{ Form::label('メールアドレス') }}</li>
    <li>{{ Form::text('mail',null,['class' => 'input']) }}</li>
  </ul>

  <ul class="login_password">
    <li class="form_label">{{ Form::label('パスワード') }}</li>
    <li>{{ Form::password('password',null,['class' => 'input']) }}</li>
  </ul>

  <ul class="login_password">
    <li class="form_label">{{ Form::label('パスワード確認') }}</li>
    <li>{{ Form::password('password_confirmation',null,['class' => 'input']) }}</li>
  </ul>

  <div class="login_button">
    {{ Form::submit('新規登録') }}
  </div>

  <p class="back_login"><a href="/login">ログイン画面へ戻る</a></p>
</div>

{!! Form::close() !!}



@endsection
