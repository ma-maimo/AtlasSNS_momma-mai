@extends('layouts.login')

@section('content')
<!-- <h2>機能を実装していきましょう。</h2> -->

<!-- つぶやきフォーム -->

<div class="container mt-3 post_form">

  {!! Form::open(['url' => '/timeline', 'method' => 'POST', 'class' => 'row']) !!}
  {{ csrf_field() }}
  <!-- {{ form::token() }} -->
  <img class="icon_tweet col-2" src="{{ asset('images/'.Auth::user()->images) }}">
  <div class="col-sm">
    <div class="form_group">
      {{ Form::text('post', null, ['required','class' => 'form-control rows="3" ', 'placeholder' => '投稿内容を入力してください。']) }}
      <!-- {{ Form::text('newPost', null, ['required','class' => 'form-control', 'placeholder' => '投稿内容を入力してください。']) }} -->
    </div>
  </div>

  <div class="post_form_btn">
    {{ Form::button('<img src="images/post.png">', ['class' => 'btn btn-block','type' => 'submit']) }}
    <!-- {{ Form::submit('', ['class' => 'btn btn-primary col-2']) }} -->
  </div>


  {{-- エラー表示 ここから --}}
  @if ($errors->has('post'))
  <p class="alert alert-danger">{{ $errors->first('post') }}</p>
  @endif
  {{-- エラー表示 ここまで --}}
  {!! Form::close() !!}
</div>


<!-- タイムライン -->
@foreach($user_posts as $post)
<ul>

  <li class="post-block">
    <figure><img class="icon_tweet" src="{{ asset('images/'.Auth::user()->images) }}"></figure>
    <div class="post-content">

      <div class="post_list">
        <div class="post-name">{{ Auth::user()->username }}</div>
        <div>{{ $post->created_at }}</div>
      </div>
      <div>{{ $post->post }}</div>


      <!-- <div class="content"> -->
      <!-- 編集ボタン -->
      <a class="btn edit-modal-open edit_btn" data-toggle="modal" data-target="#modal-example" post_id="{{$post->id}}" post="{{$post->post}}" method="post">
        <img src="images/edit.png" alt="">
      </a>
      <!-- 削除ボタン -->
      <div class="delete_btn">
        <a href="/posts/{{ $post->id }}/destroy" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
          <img src="images/trash.png" alt="">
        </a>
      </div>



      <!-- </div> -->

      <!-- モーダルの中身 編集-->
      <div class="modal edit-modal">
        <div class="modal__bg edit-modal-close"></div>
        <div class="modal__content">

          <form action="{{ route('posts.update')}}" method="post">
            <textarea name="post" class="edit_post">{{ $post->post }}</textarea>
            <input type="hidden" name="post_id" class="edit_id" value="{{ $post->id }}">
            <input type="submit" value="更新">
            {{ csrf_field() }}
          </form>
          <a class="edit-modal-close" href="/top">閉じる</a>
        </div>
      </div>




    </div>
  </li>
</ul>
@endforeach








@endsection
