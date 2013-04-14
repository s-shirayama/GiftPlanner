<?php get_header(); ?>

<div id="content">

<?php /* ?>
		 <?php include(TEMPLATEPATH."/l_sidebar.php");?>
		 <?php */ ?>

<div id="contentmiddle">

<?php
$name = $_GET["s"];
$sex = $_GET["sex"];
$age = $_GET["age"];
$relation = $_GET["relation"];
$min = $_GET["min"];
$max = $_GET["max"];
$category  = $_GET["category"];

$keywords = name2keywords( $name );
$genres = get_genres( $sex, $age, $relation, $category );

// API呼び出し
// 結果が1件以上になるまでkeywordを変えながらAPIを叩く
foreach( $keywords as $keyword ){
		$response = get_products_info( $keyword, $sex, $age, $genres, $min, $max );
		$tmp = json_decode( $response->getHttpResponse()->getContents() );
		echo "<!-- " . $keyword . " : " . $tmp->count . "-->\n";
		if( $tmp->count > 0 ){
				break;
		}
}
?>

<?php /* TODO:TABLEではなくCSSでをカラムを分ける */ ?>

<div id="gift_style_main">

<div class="gift_list_box">

<h2><?php echo $name; ?>　さんへのお勧めプレゼント！</h2>

<ul id="itemlist">
<?php foreach ($response as $item): ?>
<ul>
<li class="item">

<a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>">
<?php echo h(mb_strimwidth($item['itemName'], 0, 80, '...', 'UTF-8')) ?></a>

<?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
<li class="image"><img src="<?php echo h($item['mediumImageUrls'][0]['imageUrl']) ?>"></li>
<?php endif; ?>
<!--<li class="addbookmark"><a href="bookmark.php?itemCode=<?php echo h($item['itemCode']) ?>&amp;keyword=<?php echo h($keyword) ?>&amp;page=<?php echo h($page) ?>">ブックマークへ追加</a></li>-->
<li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
<!--<li class="description"><?php echo h($item['itemCaption']) ?></li>-->

</li>
</ul>

<hr size="0.7px" noshade />

<?php endforeach; ?>
</ul>

</div>
<div class="gift_search_box">

<form method="GET">
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

</div>

</div>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>
