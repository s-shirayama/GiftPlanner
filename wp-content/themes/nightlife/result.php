<?php get_header(); ?>
<div id="content">

<?php /* ?>
<?php include(TEMPLATEPATH."/l_sidebar.php");?>
<?php */ ?>

<div id="contentmiddle">

<?php
require_once '/var/lib/php/rws-php-sdk-master/autoload.php';
require_once '/var/lib/php/rws-php-sdk-master/sample/config.php';
require_once '/var/lib/php/rws-php-sdk-master/sample/helper.php';

    $keyword   = "時計";
    $page      = 1;

    // Clientインスタンスを生成 Make client instance
    $rwsclient = new RakutenRws_Client();
    // アプリIDをセット Set Application ID
    $rwsclient->setApplicationId(RAKUTEN_APP_ID);
    // アフィリエイトIDをセット (任意) Set Affiliate ID (Optional)
    $rwsclient->setAffiliateId(RAKUTEN_APP_AFFILITE_ID);

    // プロキシの設定が必要な場合は、ここで設定します。
    // If you want to set proxy, please set here.
    // $rwsclient->setProxy('proxy');

    // 楽天市場商品検索API2 で商品を検索します
    // Search by IchibaItemSearch (http://webservice.rakuten.co.jp/api/ichibaitemsearch/)
    $response = $rwsclient->execute('IchibaItemSearch', array(
        'keyword' => $keyword,
        'page'    => $page,
        'hits'    => 9
    ));

#var_dump( $response );

?>

<ul id="itemlist">
<?php foreach ($response as $item): ?>
<li class="item">

<a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>">
<?php echo h(mb_strimwidth($item['itemName'], 0, 80, '...', 'UTF-8')) ?></a>

<ul>
<?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
<li class="image"><img src="<?php echo h($item['smallImageUrls'][0]['imageUrl']) ?>"></li>
<?php endif; ?>
<li class="addbookmark"><a href="bookmark.php?itemCode=<?php echo h($item['itemCode']) ?>&amp;keyword=<?php echo h($keyword) ?>&amp;page=<?php echo h($page) ?>">ブックマークへ追加</a></li>
<li class="price"><?php echo h(number_format($item['itemPrice'])) ?>円</li>
<li class="description"><?php echo h($item['itemCaption']) ?></li>
</ul>

</li>
<?php endforeach; ?>
</ul>





<?php /* ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<div class="contentdate">
		<h3><?php the_time('M'); ?></h3>
		<h4><?php the_time('j'); ?></h4>
	</div>	
	<div class="contenttitle">
		<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<p>カテゴリー <?php the_category(', ') ?></p>
	</div>
	<div class="entry-content"><?php the_content(__('続きを読む'));?></div>
	<div style="clear:both;"></div>
	<?php include("postinfo.php"); ?>
	<!-- <?php trackback_rdf(); ?> -->

</div><!-- .post -->

<?php endwhile; else: ?>
	<p><?php _e('お探しのページは見つかりませんでした。'); ?></p><?php endif; ?>
	<?php posts_nav_link(' &#8212; ', __('&laquo; 戻る'), __('他のキーワードで検索 &raquo;')); ?>
<?php */ ?>

</div><!-- #contentmiddle -->
	
</div><!-- #content -->
<?php get_footer(); ?>
