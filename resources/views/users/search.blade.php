@extends('layouts.login')

@section('content')


<!-- <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @foreach ($users as $user)
      <div class="card">
        <div class="card-haeder p-3 w-100 d-flex">
          <img src="{{ asset('images/'.$user->images) }}" class="rounded-circle" width="50" height="50">
          <div class="ml-2 d-flex flex-column">
            <p class="mb-0"></p>
            <a href="" class="text-secondary"></a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="my-4 d-flex justify-content-center">

  </div>
</div> -->

<!-- 検索 -->
<div class="search">
  <form action="{{ route('users.searchView') }}" method="GET">
    @csrf
    <input type="text" name="keyword" placeholder="ユーザー名" value="@if(isset($keyword)){{$keyword}}@endif">
    <button type="submit">
      <img src="{{ asset('images/search.png') }}" alt="">
    </button>
    <!-- <div class="row "></div> -->
  </form>
  <div class="follow_list">
  </div>

</div>

<!-- 検索ワード -->
@if(!empty($keyword))
<p>検索ワード：{{$keyword}}</p>
@endif

<div class="my-4 d-flex">
</div>



<div class="container">
  <div class="row ">
    @foreach ($users as $user)
    <div class="col-md-8">
      @if(isset($user)and!(Auth::user()==$user))
      <div class="follow_list_tubuyaki">
        <div class="p-3 w-100 d-flex">
          <img src="{{ asset('images/'.$user->images) }}" class="rounded-circle" width="50" height="50">
          <p class="mb-0">{{ $user->username }}</p>

          <!-- フォロー機能 -->
          <!-- ログインしているユーザーとフォローするユーザーのデータを送る -->
          @if(Auth::user()->isFollow($user->id))
          <!-- User.phpのisFollowに飛ぶ -->
          <form method="POST" action="{{ route('users.unfollow') }}">
            @csrf
            <input name="followed_id" type="hidden" value="{{ $user->id }}" />
            <button type="submit">
              フォロー解除
            </button>
          </form>
          @else
          <form method="POST" action="{{ route('users.follow') }}">
            @csrf
            <input name="followed_id" type="hidden" value="{{ $user->id }}" />
            <button type="submit">
              フォローする
            </button>
          </form>
          @endif
        </div>
      </div>
      @endif
    </div>
    @endforeach
    <!-- <div class="my-4 d-flex">
    </div> -->
  </div>
</div>



@endsection
