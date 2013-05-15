<?php 
global $facebook;

// Facebook連携済み、ログイン済みであるかの確認
if( $facebook->getUser() ) {
    // ログイン済みの場合友達一覧を取得
    try{
	$friends = $facebook->api('/me/friends', array( 'fields' => 'id,name,picture', 'locale' => 'ja_JP' ));
    } catch (FacebookApiException $e) {
	if (0) { // 開発中はここでエラー表示後に終了、0にするとFacebook提供サンプルと同じ処理に
	    echo $e;
	    exit;
	}
	error_log($e);
	$user = null;
    }
} else {
    // このアプリの認証画面を表示する
    $permis = "friends_status"; // 友達の投稿情報(チェックイン含む)
    $permis .= ",friends_photos"; // 友達の写真情報
    $url = $facebook->getLoginUrl(array('scope' => $permis));
    
    // アプリ未登録ユーザーなら facebook の認証ダイアログページへ遷移
    echo "<script type='text/javascript'>top.location.href = '$url';</script>";
    exit;
}


?>

<style type="text/css">
  #contentmiddle ul .fb_fr_lst {
  border: 1px solid #e9eaed;
  display: inline-block;
  margin: 0 0 13px 13px;
  padding: 0 10px 0 0;
  vertical-align: top;
  width: 300px;
  }
  
  .fb_fr_img_a {
  float: left;
  }

  .fb_fr_nm {
  display: inline-block;
  vertical-align: middle;
  font-size: 13;
  font-weight: bold;
  }
</style>

<script type="text/javascript">
  function update_fb_fr_lst( num ){
  var tmp_value = document.getElementById("fb_fr_search").value;
  var tmp_string = "<ul>\n";
  var len = FB_FR_LST.length;
  var cnt = 0;
  var CNT_LIMIT = Math.max(10, num);
  for( var i = 0; i < len; i++ ){
  var re = new RegExp(tmp_value);
  if( FB_FR_LST[i]['name'].match(re) ){
  if( ++cnt > CNT_LIMIT ){
  break;
  }
  tmp_string += '<li class="fb_fr_lst">\n';
  tmp_string += '<a class="fb_fr_img_a" href="/?s=' + FB_FR_LST[i]['name'] + '&fbid=' + FB_FR_LST[i]['id'] + '">\n';
  tmp_string += '<img src="' + FB_FR_LST[i]['img'] + '" /></a>\n';
  tmp_string += '<div class="fb_fr_nm" style="height: 50px"></div>\n';
  tmp_string += '<div class="fb_fr_nm">\n';
  tmp_string += '<a href="/?s=' + FB_FR_LST[i]['name'] + '&fbid=' + FB_FR_LST[i]['id'] + '">\n';
  tmp_string += FB_FR_LST[i]['name'] + '</a>\n';
  tmp_string += '</li>\n';
  }
  }
  tmp_string += "</ul>";
  if( cnt > CNT_LIMIT ){
  tmp_string += '<br />検索結果の内' + CNT_LIMIT + '件を表示しています<br />\n';
  tmp_string += '<input type="button" value="もっと見る" onclick="update_fb_fr_lst(' + (CNT_LIMIT + 10) + ')" />\n';
  }
  document.getElementById("fb_fr_lst").innerHTML = tmp_string;
  }
  var FB_FR_LST = Array();
  var tmp = Array();

  <?php
foreach( $friends['data'] as $friend ){
    echo "FB_FR_LST.push({name:'" . $friend['name'] . "', id:'" . $friend['id'] . "', img:'" . $friend['picture']['data']['url'] . "'});\n";
}
?>
  
</script>

<?php get_header(); ?>
<div id="content">
  

  <div id="contentmiddle">
    <br />
    <div style="font-size: 15; font-weight: bold; text-align: center;">
      プレゼントを探したい友達を選んでください
    </div>
    <br />
    <div style="font-size: 15; font-weight: bold; text-align: center;">検索：
    <input type="text" id="fb_fr_search" oninput="update_fb_fr_lst(0)" />
    </div>
    <br />
    <div id="fb_fr_lst"></div>
    <script type="text/javascript">
      update_fb_fr_lst(0);
    </script>
    <div id="gift_brank"></div>
    
  </div><!-- #contentmiddle -->
  
</div><!-- #content -->

<?php get_footer(); ?>
