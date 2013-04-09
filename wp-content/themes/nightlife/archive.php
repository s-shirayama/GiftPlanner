<?php get_header(); ?>
<div id="content">
<?php include(TEMPLATEPATH."/l_sidebar.php");?>

<div id="contentmiddle">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<div class="contentdate">
		<h3><?php the_time('M'); ?></h3>
		<h4><?php the_time('j'); ?></h4>
	</div>		
	<div class="contenttitle">
		<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<p>カテゴリー <?php the_category(', ') ?>&nbsp;|&nbsp;<?php comments_popup_link('コメントする', ' コメント (1)', 'コメント (%)'); ?></p>
	</div>
	<div class="entry-content"><?php the_excerpt(__('続きを読む'));?></div>
	<div class="postspace"></div>
	<!--<?php trackback_rdf(); ?>-->
</div><?php // #post-ID ?>

<?php endwhile; else: ?>
	<p><?php _e('お探しのページは見つかりませんでした。'); ?></p><?php endif; ?>
	<?php posts_nav_link(' &#8212; ', __('&laquo; 戻る'), __('他のキーワードで検索 &raquo;')); ?>
</div><?php // #contentmiddle ?>
	
</div><?php // #content ?>
<?php get_footer(); ?>