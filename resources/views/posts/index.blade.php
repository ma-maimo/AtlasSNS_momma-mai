@extends('layouts.login')

@section('content')

<!-- つぶやきフォーム -->
<div class="container mt-3 post_form">

  {!! Form::open(['url' => '/timeline', 'method' => 'POST', 'class' => 'row']) !!}
  {{ csrf_field() }}
  <img class="icon_tweet_login col-2 rounded-circle" width="50" height="50" src=" {{ asset('storage/images/'.Auth::user()->images) }}">
  <div class="col-sm">
    <div class="form_group">
      {{ Form::text('post', null, ['required','class' => 'form-control rows="3" ', 'placeholder' => '投稿内容を入力してください。']) }}
    </div>
  </div>

  <div class="post_form_btn">
    {{ Form::button('<img src="images/post.png">', ['class' => 'btn btn-block','type' => 'submit']) }}
  </div>

  {{-- エラー表示 ここから --}}
  @if ($errors->has('post'))
  <p class="alert alert-danger">{{ $errors->first('post') }}</p>
  @endif
  {{-- エラー表示 ここまで --}}
  {!! Form::close() !!}
</div>


<!-- タイムライン -->
<ul class="timeline">
  @foreach($posts as $post)
  <li class="post_block">
    <a href="{{ url('/users/otherProfile',$post->user->id) }}" class="icon_tweet_timeline">
      <figure><img class="icon_tweet_timeline rounded-circle" width="50" height="50" src=" {{ asset('storage/images/'.$post->user->images) }}"></figure>
    </a>
    <div class="post_content">
      <div class="post_list">
        <div class="post_name">{{ $post->user->username }}</div>
        <div class="post_created_at">{{ $post->created_at }}</div>
      </div>
      <div class="post_timeline">{{ $post->post }}</div>

      @if(Auth::user() == $post->user )
      <!-- 編集ボタン -->
      <a class="btn edit-modal-open edit_btn" data-toggle="modal" data-target="#modal-example" post_id="{{$post->id}}" post="{{$post->post}}" method="post">
        <img src="images/edit.png" alt="編集ボタン">
      </a>
      <!-- 削除ボタン -->
      <div class="delete_btn">
        <a href="/posts/{{ $post->id }}/destroy" onclick="return confirm('この投稿を削除します。よろしいでしょうか？')">
          <img src="images/trash.png" alt="削除ボタン" class="trash1">
          <img src="images/trash-h.png" alt="ホバー時の削除ボタン" class="trash2">
        </a>
      </div>
      @endif

      <!-- モーダルの中身 編集-->
      <div class="modal edit-modal">
        <div class="modal__bg edit-modal-close"></div>
        <div class="modal__content">

          <form action="{{ route('posts.update')}}" method="post">
            <textarea name="post" class="edit_post d-flex">{{ $post->post }}</textarea>
            <input type="hidden" name="post_id" class="edit_id" value="{{ $post->id }}">
            <!-- <input type="submit" value="更新" class="edit_btn_modal"> -->
            <!-- <img src="images/edit.png" alt="編集ボタン"> -->
            <button type="submit" class="submit_button">
              <img src="images/edit.png" alt="更新" class="edit_btn_modal">
            </button>
            {{ csrf_field() }}
          </form>
          <!-- <a class="edit-modal-close" href="/top">閉じる</a> -->
        </div>
      </div>
    </div>
  </li>
</ul>
@endforeach








@endsection
