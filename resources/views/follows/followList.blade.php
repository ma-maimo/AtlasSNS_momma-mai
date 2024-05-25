@extends('layouts.login')

@section('content')


<!-- <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @foreach ($followUsers as $user)
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

<!-- アイコンリスト -->
<div class="container">
  <h1>フォローリスト</h1>
  <div class="row ">
    <div class="follow_list">
      @foreach ($followUsers as $user)
      <!-- <div class="d-flex flex-row"> -->
      <img src="{{ asset('images/'.$user->images) }}" class="rounded-circle" width="50" height="50">
      <!-- </div> -->
      @endforeach
    </div>
  </div>
  <div class="my-4 d-flex">
  </div>
</div>


<div class="container">
  <div class="row ">
    <div class="col-md-8">
      @foreach ($followUsers as $user)
      <div class="follow_list_tubuyaki">
        <div class="p-3 w-100 d-flex">
          <img src="{{ asset('images/'.$user->images) }}" class="rounded-circle" width="50" height="50">
          <!-- <div class="ml-2 d-flex flex-column"> -->
          <p class="mb-0">{{ $user->username }}</p>
          <!-- ここに各ユーザーのつぶやきポスト入れる -->
          <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->posts }}</a>

          <!-- </div> -->
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="my-4 d-flex">
  </div>
</div>


@endsection
