<?php get_header(); ?>

<div id="content">

  <?php /* ?>
  <?php include(TEMPLATEPATH."/l_sidebar.php");?>
  <?php */ ?>

  <div id="contentmiddle">

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

    <div id="gift_style_main">

      <div class="gift_list_box">

	<h2><?php echo $name; ?>　さんへのお勧めプレゼント！</h2>
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

	<ul id="itemlist">
	  <?php foreach ($response as $item): ?>
	  <ul>
	    <?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
	    <li class="image">
	      <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>" target="_blank">
	      <img src="<?php echo h($item['mediumImageUrls'][0]['imageUrl']) ?>">
	    </a>
	  </li>
	  <?php endif; ?>
	  <!--<li class="addbookmark"><a href="bookmark.php?itemCode=<?php echo h($item['itemCode']) ?>&amp;keyword=<?php echo h($keyword) ?>&amp;page=<?php echo h($page) ?>">ブックマークへ追加</a></li>-->
	  <li class="item">
	    <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>" target="_blank">
	    <?php echo h(mb_strimwidth($item['itemName'], 0, 50, '...', 'UTF-8')) ?></a>
	  </li>
	  <li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
	  <li class="aflink">
	    > <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" target="_blank">
	    商品詳細はこちらから</a>
	  </li>
	  <!--<li class="description"><?php echo h($item['itemCaption']) ?></li>-->
	</ul>

	  <hr size="0.7px" noshade />

	  <?php endforeach; ?>
	</ul>

      </div>
      <div class="gift_search_box">

	<form method="GET" name="search">
	  <input type="hidden" name="s" value="<?php echo $name; ?>" />
	  <h2>もっと検索したい！</h2><br />
	  <?php echo $name; ?>　さんの<br /><br />

	  <ul>
	    <b>性別は？</b>
	    <input type="radio" name="sex" value="0" checked>男性
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
	    <input type="text" name="min" size="3" />円から<input type="text" name="max" size="3" />円まで
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

	  <div class="gift_center"><input type="submit" value="これで探す！" /></div>
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

      </div>

    </div>

  </div>

  <!-- The main column ends  -->

  <?php get_footer(); ?>
