// アコーディオンメニュー
$('.menu-btn').click(function(){
  $(this).toggleClass('is-open');
  $(this).siblings('.menu').toggleClass('is-open');
});


// 編集モーダル🌷
$(function(){
    // 編集ボタン(class="js-modal-open")が押されたら開く
    $('.edit-modal-open').on('click',function(){
        // モーダルの中身(class="js-modal")の表示
        $('.edit-modal').fadeIn();
        // 押されたボタンから投稿内容を取得し変数へ格納
        var post = $(this).attr('post');
        // 押されたボタンから投稿のidを取得し変数へ格納（どの投稿を編集するか特定するのに必要な為）
        var post_id = $(this).attr('post_id');

      // 取得した投稿内容をモーダルの中身へ渡す
      $('.edit_post').val(post);
      // 取得した投稿のidをモーダルの中身へ渡す
      $('.edit_id').val(post_id);
      // console.log("post_id:", post_id);
        return false;
    });

    // 背景部分や閉じるボタン(js-modal-close)が押されたら閉じる
  $('.edit-modal-close').on('click', function () {

        // モーダルの中身(class="js-modal")を非表示
        $('.edit-modal').fadeOut();
        return false;
    });
});
