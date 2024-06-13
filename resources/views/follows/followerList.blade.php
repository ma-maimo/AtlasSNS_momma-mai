@extends('layouts.login')

@section('content')

<!-- アイコンリスト -->
<div class="container">
  <h1 class="heading">フォロワーリスト</h1>
  <div class="row ">
    <div class="follow_list">
      <div class="follow_list_icon">
        @foreach ($followerUsers as $user)
        <a href="{{ url('/users/otherProfile',$user->id) }}">
          @if($user->images == 'icon1.png')
          <img src="{{ asset('images/icon1.png') }}" alt="初期アイコン" class="rounded-circle" width="50" height="50">
          @else
          <img src="{{ asset('storage/images/'.$user->images) }}" class="rounded-circle" width="50" height="50">
          @endif
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
      <a href="{{ url('/users/otherProfile',$post->user->id) }}">
        @if($post->user->images == 'icon1.png')
        <img src="{{ asset('images/icon1.png') }}" alt="初期アイコン" class="rounded-circle" width="50" height="50">
        @else
        <img src="{{ asset('storage/images/'.$post->user->images) }}" class="rounded-circle" width="50" height="50">
        @endif
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
