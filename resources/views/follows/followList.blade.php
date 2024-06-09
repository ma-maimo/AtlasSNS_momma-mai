@extends('layouts.login')

@section('content')

<!-- アイコンリスト -->
<div class="container">
  <h1 class="heading">フォローリスト</h1>
  <div class="row ">
    <div class="follow_list">
      <div class="follow_list_icon">
        @foreach ($followUsers as $user)
        <a href="{{ url('/users/otherProfile',$user->id) }}">
          <img src="{{ asset('storage/images/'.$user->images) }}" class="rounded-circle" width="50" height="50">
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>


<!-- タイムライン -->
<div class="container_timeline">
  <ul class="timeline">
    @foreach ($posts as $post)
    <li class="post_block">
      <a href="{{ url('/users/otherProfile',$post->user->id) }}" class="icon_tweet_timeline">
        <img src="{{ asset('storage/images/'.$post->user->images) }}" class="rounded-circle" width="50" height="50">
      </a>

      <div class="post_content">
        <div class="post_list">
          <div class="post_name">{{ $post->user->username }}</div>
          <div class="post_created_at">{{ $post->created_at }}</div>
        </div>
        <div class="post_timeline">{{ $post->post }}</div>
      </div>
    </li>
    @endforeach
  </ul>
  <div class="my-4 d-flex">
  </div>
</div>


@endsection
