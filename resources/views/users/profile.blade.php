@extends('layouts.login')

@section('content')

<div class="container">
  <div class="profile_edit d-flex col-8">

    <div class="profile_icon">
      @if(Auth::user()->images == 'icon1.png')
      <img src="{{ asset('images/icon1.png') }}" alt="初期アイコン" class="icon_profile">
      @else
      <img class="icon_profile" src="{{ asset('storage/images/'.Auth::user()->images) }}">
      @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <!-- プロフィールフォーム -->
    <form action="{{ route('users.profileUpdate') }}" method="post" enctype="multipart/form-data" class="profile_edit_form">
      @csrf

      <div class="form-group d-flex">
        <label for="username">ユーザー名</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
        @if ($errors->has('username'))
        <span class="text-danger">{{ $errors->first('username') }}</span>
        @endif
      </div>

      <div class="form-group d-flex">
        <label for="mail">メールアドレス</label>
        <input type="mail" class="form-control" id="mail" name="mail" value="{{ old('mail', $user->mail) }}" required>
        @if ($errors->has('mail'))
        <span class="text-danger">{{ $errors->first('mail') }}</span>
        @endif
      </div>

      <div class="form-group d-flex">
        <label for="password">パスワード</label>
        <input type="password" class="form-control" id="password" name="password" value="" required>
        @if ($errors->has('password'))
        <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
      </div>

      <div class="form-group d-flex">
        <label for="password_confirmation">パスワード確認</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" required>
        @if ($errors->has('password'))
        <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
      </div>

      <div class="form-group d-flex">
        <label for="bio">自己紹介</label>
        <input type="text" class="form-control" id="bio" name="bio" value="{{ old('bio', $user->bio) }}">
        @if ($errors->has('bio'))
        <span class="text-danger">{{ $errors->first('bio') }}</span>
        @endif
      </div>

      <div class="form-group d-flex form-group_file">
        <label for="images">アイコン画像</label>
        <input type="file" class="form-control-file" id="images" name="images" value="">
        @if ($errors->has('images'))
        <span class="text-danger">{{ $errors->first('images') }}</span>
        @endif
      </div>


      <button type="submit" class="btn btn-danger update_btn">更新</button>
    </form>
  </div>
</div>


@endsection
