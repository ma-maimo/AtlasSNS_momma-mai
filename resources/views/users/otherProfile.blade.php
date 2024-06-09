@extends('layouts.login')

@section('content')
<!-- 他ユーザーのプロフィール -->
<div class="container mt-3 other_profile">
  <img class="icon_other_profile col-2" src="{{ asset('storage/images/'.$user->images) }}">
  <div class="other_profile_content d-flex col-10">
    <div class="profile_title">
      <p>ユーザー名</p>
      <p>自己紹介</p>
    </div>
    <div class="profile_content col-7">
      <p>{{ $user->username }}</p>
      <p>{{ $user->bio }}</p>
    </div>

    <!-- フォロー/フォロー解除ボタン -->
    @if(Auth::id() !== $user->id)
    @if(Auth::user()->isFollow($user->id))
    <form method="POST" action="{{ route('users.unfollow') }}" class="other_profile_btn">
      @csrf
      <input name="followed_id" type="hidden" value="{{ $user->id }}" />
      @if (isset($redirect_to_search) && $redirect_to_search)
      <input type="hidden" name="redirect_to_search" value="1">
      @endif
      <button type="submit" class="btn btn-danger">
        フォロー解除
      </button>
    </form>
    @else
    <form method="POST" action="{{ route('users.follow') }}" class="other_profile_btn">
      @csrf
      <input name="followed_id" type="hidden" value="{{ $user->id }}" />
      @if (isset($redirect_to_search) && $redirect_to_search)
      <input type="hidden" name="redirect_to_search" value="1">
      @endif
      <button type="submit" class="btn btn-info">
        フォローする
      </button>
    </form>
    @endif
    @endif
  </div>
</div>


<!-- タイムライン -->
@foreach($user_posts as $post)
<ul>
  <li class="post_block">
    <a href="{{ url('/users/otherProfile',$user->id) }}">
      <figure><img class="icon_other_profile" src="{{ asset('storage/images/'.$user->images) }}"></figure>
    </a>
    <div class="post_content">
      <div class="post_list">
        <div class="post_name">{{ $user->username }}</div>
        <div class="post_created_at">{{ $post->created_at }}</div>
      </div>
      <div class="post_timeline">{{ $post->post }}</div>
    </div>
  </li>
</ul>
@endforeach


@endsection
