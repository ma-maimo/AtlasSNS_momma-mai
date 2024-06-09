@extends('layouts.login')

@section('content')

<!-- 検索 -->
<div class="search">
  <form action="{{ route('users.searchView') }}" method="GET">
    @csrf
    <input type="text" name="keyword" placeholder="ユーザー名" value="@if(isset($keyword)){{$keyword}}@endif">
    <button type="submit" class="search_btn">
      <img src="{{ asset('images/search.png') }}" alt="検索ボタン">
    </button>
  </form>

  <!-- 検索ワード -->
  @if(!empty($keyword))
  <p class="keyword">検索ワード：{{$keyword}}</p>
  @endif
</div>

<div class="container">
  @foreach ($users as $user)
  <div class="col-md-8">
    @if(isset($user)and!(Auth::user()==$user))
    <div class="user_list d-flex">
      <a href="{{ url('/users/otherProfile',$user->id) }}">
        <img src="{{ asset('storage/images/'.$user->images) }}" class="rounded-circle " width="50" height="50">
      </a>
      <div class="w-100 d-flex user_list_content">
        <p class="mb-0 user_list_name">{{ $user->username }}</p>

        <!-- フォロー機能 -->
        <!-- ログインしているユーザーとフォローするユーザーのデータを送る -->
        @if(Auth::user()->isFollow($user->id))
        <!-- User.phpのisFollowに飛ぶ -->
        <form method="POST" action="{{ route('users.unfollow') }}">
          @csrf
          <input name="followed_id" type="hidden" value="{{ $user->id }}" />
          <input type="hidden" name="redirect_to_search" value="1">
          <button type="submit" class="btn btn-danger unfollow_btn">
            フォロー解除
          </button>
        </form>
        @else
        <form method="POST" action="{{ route('users.follow') }}">
          @csrf
          <input name="followed_id" type="hidden" value="{{ $user->id }}" />
          <input type="hidden" name="redirect_to_search" value="1">
          <button type="submit" class="btn btn-info follow_btn">
            フォローする
          </button>
        </form>
        @endif
      </div>
    </div>
    @endif
  </div>
  @endforeach
</div>

@endsection
