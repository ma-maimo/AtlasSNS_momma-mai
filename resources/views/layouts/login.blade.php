<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <!--IEブラウザ対策-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="ページの内容を表す文章" />
  <title>Atlas</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <!-- stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
  <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
  <!--スマホ,タブレット対応-->
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <!--サイトのアイコン指定-->
  <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
  <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
  <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
  <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
  <!--iphoneのアプリアイコン指定-->
  <link rel="apple-touch-icon-precomposed" href="画像のURL" />
  <!--OGPタグ/twitterカード-->
</head>

<body>
  <header>
    <div id="header_logo">
      <h1><a href="/top"><img class="header_logo" src="{{ asset('images/atlas.png') }}"></a></h1>
    </div>

    <div id="drop_menu">
      <p class="user_name">{{ Auth::user()->username }}　さん</p>
      @if(Auth::user()->images == 'icon1.png')
      <img src="{{ asset('images/icon1.png') }}" alt="初期アイコン" class="icon">
      @else
      <img class="icon" src="{{ asset('storage/images/'.Auth::user()->images) }}">
      @endif
      <!-- アコーディオンメニュー -->
      <button type="button" class="menu-btn">
        <span class="inn"></span>
      </button>

      <nav class="menu">
        <ul>
          <li><a href="/top">HOME</a></li>
          <li><a href="/profile">プロフィール編集</a></li>
          <li><a href="/logout">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>


  <div id="row">
    <div id="container">
      @yield('content')
    </div>
    <div id="sidebar">
      <div id="confirm">
        <p class="sidebar_username">{{ Auth::user()->username }}さんの</p>
        <div>
          <p class="follow_count">フォロー数</p>
          <p class="count_number">{{ Auth::user()->follows()->count() }}人</p>
        </div>
        <a href="/followList"><button type="button" class="btn btn-primary">フォローリスト</button></a>
        <div>
          <p class="follower_count">フォロワー数</p>
          <p class="count_number">{{ Auth::user()->followers()->count() }}人</p>
        </div>
        <a href="/followerList"><button type="button" class="btn btn-primary">フォロワーリスト</button></a>
      </div>
      <a href="/search"><button type="button" class="btn btn-primary btn-primary-search">ユーザー検索</button></a>
    </div>
  </div>

  <footer>
    <!-- BootsStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
  </footer>

</body>

</html>
