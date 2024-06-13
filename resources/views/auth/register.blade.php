@extends('layouts.logout')

@section('content')

<!-- 新規登録フォーム -->
{!! Form::open(['url' => '/register']) !!}
<div class="register_wrapper">

  <h2 class="register">新規ユーザー登録</h2>

  <ul class="login_username">
    @if ($errors->has('username'))
    <span class="text-danger">{{ $errors->first('username') }}</span>
    @endif
    <li class="form_label">{{ Form::label('ユーザー名') }}</li>
    <li>{{ Form::text('username',null,['class' => 'input']) }}</li>
  </ul>

  <ul class="login_mail">
    @if ($errors->has('mail'))
    <span class="text-danger">{{ $errors->first('mail') }}</span>
    @endif
    <li class="form_label">{{ Form::label('メールアドレス') }}</li>
    <li>{{ Form::text('mail',null,['class' => 'input']) }}</li>
  </ul>

  <ul class="login_password">
    @if ($errors->has('password'))
    <span class="text-danger">{{ $errors->first('password') }}</span>
    @endif
    <li class="form_label">{{ Form::label('パスワード') }}</li>
    <li>{{ Form::password('password',null,['class' => 'input']) }}</li>
  </ul>

  <ul class="login_password">
    @if ($errors->has('password'))
    <span class="text-danger">{{ $errors->first('password') }}</span>
    @endif
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
