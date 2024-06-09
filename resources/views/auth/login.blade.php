@extends('layouts.logout')

@section('content')
{!! Form::open(['url' => '/login']) !!}

<div class="welcome_wrapper">

  <p class="welcome_text">AtlasSNSへようこそ</p>

  <div class="login_form">
    <ul class="login_mail">
      <li class="form_label">{{ Form::label('メールアドレス') }}</li>
      <li>{{ Form::text('mail',null,['class' => 'input']) }}</li>
    </ul>

    <ul class="login_password">
      <li class="form_label">{{ Form::label('パスワード') }}</li>
      <li>{{ Form::password('password',['class' => 'input']) }}</li>
    </ul>
  </div>

  <div class="login_button">
    {{ Form::submit('ログイン') }}
  </div>

  <p class="welcome_new"><a href="/register">新規ユーザーの方はこちら</a></p>

</div>

{!! Form::close() !!}

@endsection
