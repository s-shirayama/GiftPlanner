<?php get_header(); ?>
<div id="content_gp_middle">
<div id="content_gp_top">
<div id="content">
  <?php /* include(TEMPLATEPATH."/l_sidebar.php"); */ ?>

      <div class="gp_tb13">
        <form method="GET" action="<?php echo get_settings('home'); ?>">
        <input class="gp_tb11" type="text" name="s" placeholder="プレゼントしたい人の名前を入力してください">
        <input class="gp_tb12" type="submit" value="検索">
        </form>
		<a href="/fb/"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_facebook_l.jpg" alt="Facebook" width="25px" height="25px"></a>
      </div>

	<div class="gp_title_page">
    <h2>
    <?php $cat = get_queried_object(); /* オブジェクトを取得 */ ?>
    <?php if($cat -> parent != 0): /* 親カテゴリーの有無 */?>
    <?php $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' )); /* 祖先カテゴリーの取得 */ ?>
    <?php foreach($ancestors as $ancestor): /* 親カテゴリーの数だけ繰り返し処理 */ ?>
    <a href="<?php echo get_category_link($ancestor); ?>"><?php echo get_cat_name($ancestor); ?></a> -
    <?php endforeach; ?>
    <?php endif; ?>
    <?php echo $cat -> cat_name; ?>一覧
    </h2>
	</div>

	<!--<div id="contentmiddle">-->
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
    <!--<div class="contentdate">
	<h3><?php the_time('M'); ?></h3>
	<h4><?php the_time('j'); ?></h4>
	</div>-->		
	<div id="content_archive">
	  <p class="gift_line"><?php the_time('Y'); echo '年' ?><?php the_time('M');?><?php the_time('j'); echo '日'?></p>
	  <h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
	  <!--<p>カテゴリー <?php the_category(', ') ?>&nbsp;|&nbsp;<?php comments_popup_link('コメントする', ' コメント (1)', 'コメント (%)'); ?></p>-->
	</div>
	<!--<div class="entry-content"><?php the_excerpt(__('続きを読む'));?></div>-->
	<div class="postspace"></div>
	<!--<?php trackback_rdf(); ?>-->
	</div><?php // #post-ID ?>

	<?php endwhile; else: ?>
	<p><?php _e('お探しのページは見つかりませんでした。'); ?></p><?php endif; ?>
	<?php posts_nav_link(' &#8212; ', __('&laquo; 戻る'), __('他のキーワードで検索 &raquo;')); ?>
	<!--</div><?php // #contentmiddle ?>--->

	</div><?php // #content ?>
	</div><!-- #content_gp_middle -->
	</div><!-- #content_gp_top -->
	</div><!-- #wrap -->
	<?php get_footer(); ?>
