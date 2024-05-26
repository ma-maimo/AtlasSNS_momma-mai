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

use App\Http\Controllers\FollowsController;
use App\Http\Controllers\UsersController;

Route::get('/login', 'Auth\LoginController@login')->name("login");
Route::post('/login', 'Auth\LoginController@login');

// Route::get('/register', 'Auth\RegisterController@register');
// 変更
Route::get('/register', 'Auth\RegisterController@registerView');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/added', 'Auth\RegisterController@added');
Route::post('/added', 'Auth\RegisterController@added');

// ログアウト
Route::get('/logout', 'Auth\LoginController@logout');




// ミドルウェア（ログイン者のみ閲覧権限）
Route::group(['middleware' => 'auth'], function () {

  //ログイン中のページ
  Route::get('/top', 'PostsController@index');
  Route::post('/top', 'PostsController@show');

  Route::get('/profile', 'UsersController@profile');

  Route::get('/search', 'UsersController@index');

  // タイムライン
  Route::post('/timeline', 'PostsController@postCreate')->name('post');

  // 編集
  Route::post('/posts/update', 'PostsController@update')->name('posts.update');

  // 削除
  Route::get('/posts/{id}/destroy', 'PostsController@destroy');


  // // フォローリスト
  Route::get('/followList', 'FollowsController@index')->name('users.index');
  Route::post('/followList', 'FollowsController@follow')->name('users.follow');
  Route::get('/followList', 'FollowsController@followUsers')->name('users.followUsers');

  // // フォロワーリスト
  Route::get('/followerList', 'FollowsController@index')->name('users.index');
  Route::post('/followerList', 'FollowsController@follow')->name('users.follow');
  Route::get('/followerList', 'FollowsController@followersUsers')->name('users.followersUsers');

  // フォローボタン
  Route::post('/unfollow', 'FollowsController@unfollow')->name('users.unfollow'); //フォロー解除 見えないページ
  Route::post('/follow', 'FollowsController@follow')->name('users.follow'); //フォロー 見えないページ

  // ユーザー検索
  Route::post('/users/search', 'UsersController@search')->name('users.search');
  Route::get('/users/search', 'UsersController@searchView')->name('users.searchView');

  // プロフィール編集
  Route::get('/profile', 'UsersController@edit')->name('users.edit');
  Route::post('/profile', 'UsersController@update')->name('users.update');
});
