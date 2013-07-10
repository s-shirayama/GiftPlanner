<?php get_header(); ?>
<div id="content_gp_middle">
<div id="content_gp_top">
<div id="content">
<?php //include(TEMPLATEPATH."/l_sidebar.php");?>

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
	<div class="entry-content"><?php the_content(__('続きを読む'));?></div>
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
