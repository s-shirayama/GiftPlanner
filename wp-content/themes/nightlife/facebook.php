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
  #fb_fr_lst {
  /*border: 1px solid #e9eaed;*/
  display: inline-block;
  margin: 0 0 13px 13px;
  /*padding: 0 10px 0 0;*/
  vertical-align: top;
  /*width: 300px;*/
  }

  #fb_fr_lst li {
  float: left;
  height: 107px;
  }

  #content .gp_top_fb_search h4 {
  border-left: 5px solid #FFC0CB;
  padding-left: 10px;
  border-bottom: 1px solid #FFC0CB;
  padding-left: 10px;
  padding-bottom: 3px;
  font-weight: normal;
  margin: 17px 0px 5px 10px;
  width: 92%;
  }
  
  #fb_fr_lst .fb_fr_img_a {
  float: left;
  }

  #fb_fr_lst .fb_fr_img_a a:hover img {
  opacity: 0.6;
  }

  #fb_fr_lst .fb_fr_nm {
  /*display: inline-block;*/
  vertical-align: middle;
  font-size: 10px;
  /*font-weight: bold;*/
  width: 57px;
  }
</style>

<script type="text/javascript">
  function update_fb_fr_lst( num ){
  var tmp_value = document.getElementById("fb_fr_search").value;
  var tmp_string = "<ul>\n";
  var len = FB_FR_LST.length;
  var cnt = 0;
  var CNT_LIMIT = Math.max(13, num);
  for( var i = 0; i < len; i++ ){
  var re = new RegExp(tmp_value);
  if( FB_FR_LST[i]['name'].match(re) ){
  if( ++cnt > CNT_LIMIT ){
  break;
  }
  tmp_string += '<li class="fb_fr_lst">\n';
  tmp_string += '<a class="fb_fr_img_a" href="/?s=' + FB_FR_LST[i]['name'] + '&fbid=' + FB_FR_LST[i]['id'] + '">\n';
  tmp_string += '<img src="' + FB_FR_LST[i]['img'] + '" /></a>\n';
  /*tmp_string += '<div class="fb_fr_nm" style="height: 50px"></div>\n';*/
  tmp_string += '<div class="fb_fr_nm">\n';
  tmp_string += '<a href="/?s=' + FB_FR_LST[i]['name'] + '&fbid=' + FB_FR_LST[i]['id'] + '">\n';
  tmp_string += FB_FR_LST[i]['name'] + '</a>\n';
  tmp_string += '</li>\n';
  }
  }
  tmp_string += "</ul>";
  if( cnt > CNT_LIMIT ){
  tmp_string += '<br style="clear:both;"/>検索結果の内' + CNT_LIMIT + '件を表示しています<br />\n';
  tmp_string += '<input class="gp_tb12" type="button" value="もっと表示する" onclick="update_fb_fr_lst(' + (CNT_LIMIT + 13) + ')" />\n';
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
<div id="gift_breadcrumb">
  <ul>
    <li><a href="<?php echo home_url(); ?>/">HOME</a></li>
    <li>-</li>
    <li>フェイスブックでつながっている友達へのプレゼントを検索！</li>
  </ul>
</div>
<div id="content_gp_middle">
  <div id="content_gp_top">
    <div id="content">
      <div class="gp_social_wg"><?php echo get_the_social_widgets(); ?></div>
      <div class="gp_title"><h2>フェイスブックでつながっている友達へのプレゼントを検索！</h2></div>

      <div class="gp_top_main">
		<h3>フェイスブックアカウントで、プレゼント探し</h3>

	    <div class="gp_top_main_desc">
	      <p>フェイスブックでつながっている友達から簡単にプレゼント検索ができます。名前の入力は必要ありません。１クリックでお勧めのプレゼントをお探しします。</p>
	    </div>
	  </div>

	 <div class="gp_top_main">

		<div class="gp_top_fb_search">

		<input class="gp_tb11_fb" type="text" id="fb_fr_search" oninput="update_fb_fr_lst(0)" placeholder="アカウントの絞込ができます"/>

		<!--<hr style="border-top: 1px dashed pink;width: 100%;clear: both;">-->
		<div class="gift_line"></div>

		<!-- <h4>もうすぐ誕生日！</h4> -->

		<h4>あなたの友達一覧</h4>

        <div id="fb_fr_lst"></div>
	      <script type="text/javascript">
			update_fb_fr_lst(0);
	      </script>
		</div>

	 </div>

      <div id="gift_brank"></div>
    </div><!-- #content -->
  </div><!-- #content_gp_top -->
</div><!-- #content_gp_middle -->

<?php get_footer(); ?>
