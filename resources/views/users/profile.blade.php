@extends('layouts.login')

@section('content')

<div class="container">
  <div class="profile_icon">
    <img class="profile_icon" src="{{ asset('images/'.Auth::user()->images) }}">

  </div>

  @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <form action="{{ route('users.update') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label for="name">ユーザー名</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ old('username', $user->username) }}" required>
      @if ($errors->has('name'))
      <span class="text-danger">{{ $errors->first('name') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="email">メールアドレス</label>
      <input type="email" class="form-control" id="email" name="email" value="{{ old('mail', $user->mail) }}" required>
      @if ($errors->has('email'))
      <span class="text-danger">{{ $errors->first('email') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="password">パスワード</label>
      <input type="password" class="form-control" id="password" name="password" value="" required>
      @if ($errors->has('password'))
      <span class="text-danger">{{ $errors->first('password') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="password_confirmation">パスワード確認</label>
      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" required>
      @if ($errors->has('password'))
      <span class="text-danger">{{ $errors->first('password') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="bio">自己紹介</label>
      <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio', $user->bio) }}">
      @if ($errors->has('bio'))
      <span class="text-danger">{{ $errors->first('bio') }}</span>
      @endif
    </div>

    <div class="form-group">
      <label for="images">アイコン画像</label>
      <input type="file" class="form-control-file" id="images" name="images" value="">
      @if ($errors->has('images'))
      <span class="text-danger">{{ $errors->first('images') }}</span>
      @endif
    </div>


    <button type="submit" class="btn btn-primary">更新</button>
  </form>
</div>


@endsection
