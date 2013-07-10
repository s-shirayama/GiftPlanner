<?php get_header(); ?>

<div id="content_gp_middle">
  <div id="content_gp_top">
    <div id="content">

      <?php /* ?>
      <?php include(TEMPLATEPATH."/l_sidebar.php");?>
      <?php */ ?>

      <div class="gp_social_wg">
	<?php echo get_the_social_widgets();?>
      </div>

      <?php
     $name = $_GET["s"];
$fbid = $_GET["fbid"];
$sex = $_GET["sex"];
$age = $_GET["age"];
$relation = $_GET["relation"];
$min = $_GET["min"];
$max = $_GET["max"];
$category  = $_GET["category"];

if( $fbid && $facebook->getUser() ){
    $messages = fbid2messages( $fbid );
    $keywords = messages2keywords( $messages );
} else {
    $messages = name2messages( $name );
    $keywords = messages2keywords( $messages );
}
$genres = get_genres( $sex, $age, $relation, $category );

// API呼び出し
// 結果が1件以上になるまでkeywordを変えながらAPIを叩く
foreach( $keywords as $keyword ){
    $response = get_products_info( $keyword, $sex, $age, $genres, $min, $max );
    $tmp = json_decode( $response->getHttpResponse()->getContents() );
    echo "<!-- " . $keyword . " : " . $tmp->count . "-->\n";
    if( $tmp->count > 0 ){
	$s_keyword = $keyword;
	break;
    }
}
?>

<div class="gp_title">
  <h2><?php echo $name; ?>　さんへのお勧めプレゼント！</h2>
</div>

<div class="gp_top_main">
  <p>プレゼント検索キーワード： [ <?php echo $s_keyword; ?> ]</p>

  <div id="lista1">
    <div class="als-container" id="my-als-list">
      <span class="als-prev"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_thin_left_arrow.png" alt="prev" title="previous" /></span>
      <div class="als-viewport">
	<ul class="als-wrapper">
	  <?php foreach ($response as $item): ?>
	  <?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
	  <li class="als-item">
	    <div id="lista2">
	      <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>" target="_blank"><img src="<?php echo h($item['mediumImageUrls'][0]['imageUrl']) ?>"></a>
	      <p><a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>" target="_blank"><?php echo h(mb_strimwidth($item['itemName'], 0, 30, '...', 'UTF-8')) ?></a></p>
	      <?php echo '<div class="starlevel5 star' . sprintf('%02d',floor($item['reviewAverage']*2)*5) . '"></div>' ?>
	      <p><?php echo h(number_format($item['itemPrice'])) ?>円</p>
	      <p>[ <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" target="_blank">詳細はこちら</a> ]</p>
	      <br/><br/>
	    </div>
	  </li>
	  <?php endif; ?>
	  <?php endforeach; ?>
	</ul> <!-- als-wrapper end -->
      </div> <!-- als-viewport end -->
      <span class="als-next"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_thin_right_arrow.png" alt="next" title="next" /></span> <!-- "next" button -->
    </div> <!-- als-container end -->
  </div>
</div>
<h3>もっと検索したい！</h3>
<div class="gp_top_main_desc">
  <p>もっとよいプレゼントがないかな。</p>
  <p>そんなときは、プレゼント絞り込み検索をお勧めします。</p>
  <p>プレゼントしたい人の「性別」や「年代」「あなたとの関係」等の条件で絞っていただくと、よりマッチした商品が表示されます。</p>
  <hr style="border-top: 1px dashed pink;width: 100%;"/>
  <p>[ 今回の検索で参考にした記事 ]</p>
  <p>
    <?php
    foreach( $messages as $message ){
    $r_message = str_replace( $s_keyword, '<span style="font-size: 12.5px; font-wegiht: bold; color: red;">' . $s_keyword . '</span>', $message);
    echo "<li style=\"list-style-type: none;\">" . $r_message . "</li>"; } ?>
  </p>
  <p>（※赤字は商品検索キーワードです。）</p>
</div>
<div class="gp_top_main_search">
  <h4>プレゼント絞り込み検索</h4>
  <form method="GET" name="search">
    <input class="gp_tb11" type="text" name="s" placeholder="<?php echo $_GET["s"]; ?>" value="<?php echo $_GET["s"]; ?>"> 

    <ul>
      <b>性別は？</b>
      <input type="radio" name="sex" value="0" checked="">男性
      <input type="radio" name="sex" value="1">女性
    </ul>

    <ul>
      <b>年代は？</b>
      <select name="age">
	<option value="10">10代</option>
	<option value="20">20代</option>
	<option value="30">30代</option>
	<option value="40">40代</option>
	<option value="50">50代以上</option>
      </select>
    </ul>

    <ul>
      <b>あなたとの関係は？</b>
      <select name="relation">
	<option value=""></option>
	<option value="10">友達</option>
	<option value="20">上司</option>
	<option value="30">彼氏</option>
	<option value="40">彼女</option>
	<option value="50">母親</option>
	<option value="60">父親</option>
      </select>
    </ul>

    <ul>
      <b>あなたの予算は？</b>
      <input type="text" name="min" size="3">円から<input type="text" name="max" size="3">円まで
    </ul>

    <ul>
      <b>何の日ですか？</b>
      <select name="category">
	<option value=""></option>
	<option value="10">誕生日</option>
	<option value="20">クリスマス</option>
	<option value="30">父の日</option>
	<option value="40">母の日</option>
	<option value="50">送別会</option>
      </select>
    </ul>

    <div class="gift_center"><input class="gp_tb12" type="submit" value="上記で絞り込み検索する"></div>
  </form>

  <?php // 検索パラメータからFORMの初期値をセット(GP-14) ?>
  <script type="text/javascript">
    <?php if( $sex !== "" && $sex !== undefined && !is_null($sex) ){ ?>
    document.search.sex["<?php echo $sex ?>"].checked = true;
    <?php } ?>
    document.search.age.value = "<?php echo $age ?>";
    document.search.relation.value = "<?php echo $relation ?>";
    document.search.min.value = "<?php echo $min ?>";
    document.search.max.value = "<?php echo $max ?>";
    document.search.category.value = "<?php echo $category ?>";
  </script>

  <br>
    <h4>ソーシャルサービスへのログイン</h4>
    <p><a href="/fb/"><img src="http://gift-planner.net:8080/wp-content/themes/nightlife/images_gift/gp_facebook_l.jpg" alt="Facebook" width="30px" height="30px"></a>
    <!--<a href="/tw/"><img src="http://gift-planner.net:8080/wp-content/themes/nightlife/images_gift/gp_twitter.jpg" alt="Twitter" width="30px" height="30px"/></a>-->
  </p>
</div>

<!--
    <h3><?php echo $name; ?>　さんへのお勧めプレゼント！</h3>
    プレゼント検索キーワード：　<span style="font-size: 14px; font-wegiht: bold; color: red;"><?php echo $s_keyword; ?></span>　
    <span class="watch_messages">
    <button class="ms_button" disabled="true">記事内容を見る</button>
    <span class="messages">
    <ul>
    <?php
	foreach( $messages as $message ){
	$r_message = str_replace( $s_keyword, '<span style="font-size: 14px; font-wegiht: bold; color: red;">' . $s_keyword . '</span>', $message);
	echo "<li>" . $r_message . "</li>";
    }
?>
</ul>
</span>
</span>
<br /><br />
-->

<br style="clear: both;"/>
<br/>

<div class="gp_top_main">
  <h3>プレゼントカテゴリー</h3>
  <div class="gp_top_category">
    <?php include(TEMPLATEPATH."/GP_present_category.php"); ?>
  </div>
</div><!-- gp_top_main -->

</div>

</div>

</div>

<!-- The main column ends  -->

</div><!-- wrap -->

<?php get_footer(); ?>
