<?php get_header(); ?>
<div id="content_gp_middle">
<div id="content_gp_top">
<div id="content">
<?php //include(TEMPLATEPATH."/l_sidebar.php");?>

      <div class="gp_tb13">
        <form method="GET" action="<?php echo get_settings('home'); ?>">
        <input class="gp_tb11" type="text" name="s" placeholder="プレゼントしたい人の名前を入力してください">
        <input class="gp_tb12" type="submit" value="検索">
        </form>
        <a href="/fb/"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_facebook_l.jpg" alt="Facebook" width="25px" height="25px"></a>
      </div>

<!--<div id="contentmiddle">-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<!--<div class="contentdate">
		<h3><?php the_time('M'); ?></h3>
		<h4><?php the_time('j'); ?></h4>
	</div>-->
	<!--<div class="contenttitle">-->
	<div class="gp_title_page">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<!--<p>カテゴリー <?php the_category(', ') ?></p>-->
	</div>
	<div class="entry-content">
		<?php the_content(__('続きを読む'));?>
		<br/>
		<h4>おすすめ商品紹介：</h4>
		<div><!-- Rakuten Widget FROM HERE --><script type="text/javascript">rakuten_design="slide";rakuten_affiliateId="11a05f2a.3f3d9bdd.11a05f2b.64a622ed";rakuten_items="ctsmatch";rakuten_genreId=0;rakuten_size="600x200";rakuten_target="_blank";rakuten_theme="gray";rakuten_border="off";rakuten_auto_mode="off";rakuten_genre_title="off";rakuten_recommend="on";</script><script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js"></script><!-- Rakuten Widget TO HERE --></div>
		<br style="clear:both;"/>
		<h4>フェイスブックからコメントする：</h4>
		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="470" data-num-posts="3"></div>
	</div>
	<div style="clear:both;"></div>
	<!--<?php trackback_rdf(); ?>-->
	<!--<h1>コメント</h1>-->
	<?php // comments_template('', true); ?>
</div><?php // #post-ID ?>

<?php endwhile; else: ?><br />
	<p><?php _e('お探しのページは見つかりませんでした。'); ?></p>
<?php endif; ?>
<!--</div>--><?php // #contentmiddle ?>
	
</div><?php // #content ?>
</div><!-- #content_gp_middle -->
</div><!-- #content_gp_top -->
</div><!-- #wrap -->
<?php get_footer(); ?>
