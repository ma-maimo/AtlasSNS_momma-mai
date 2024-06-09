<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login')->name("login");
Route::post('/login', 'Auth\LoginController@login');

// 変更
Route::get('/register', 'Auth\RegisterController@registerView');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');
Route::post('/added', 'Auth\RegisterController@added');

// ログアウト
Route::get('/logout', 'Auth\LoginController@logout');


// ミドルウェア（ログイン者のみ閲覧権限）
Route::group(['middleware' => 'auth'], function () {

  //トップページ
  Route::get('/top', 'PostsController@index');
  Route::post('/top', 'PostsController@show');

  // タイムライン
  Route::post('/timeline', 'PostsController@postCreate')->name('post');

  // 編集機能
  Route::post('/posts/update', 'PostsController@update')->name('posts.update');

  // 削除機能
  Route::get('/posts/{id}/destroy', 'PostsController@destroy');

  // // フォローリスト
  Route::get('/followList', 'FollowsController@followList')->name('users.followList');
  Route::post('/followList', 'FollowsController@follow')->name('users.follow');

  // // フォロワーリスト
  Route::get('/followerList', 'FollowsController@followerList')->name('users.followerList');
  Route::post('/followerList', 'FollowsController@follow')->name('users.follow');

  // フォローボタン
  Route::post('/unfollow', 'FollowsController@unfollow')->name('users.unfollow'); //フォロー解除 見えないページ
  Route::post('/follow', 'FollowsController@follow')->name('users.follow'); //フォロー 見えないページ

  // ユーザー検索
  Route::get('/search', 'UsersController@index');
  Route::get('/users/search', 'UsersController@searchView')->name('users.searchView');

  // プロフィール編集
  Route::get('/profile', 'UsersController@profile')->name('users.profile');
  Route::post('/profile/profileUpdate', 'UsersController@profileUpdate')->name('users.profileUpdate');

  // 相手のプロフィール
  Route::get('/users/otherProfile/{id}', 'UsersController@otherProfile')->name('users.otherProfile');
});
