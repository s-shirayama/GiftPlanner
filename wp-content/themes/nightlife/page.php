<?php get_header(); ?>
<div id="content">
<?php //include(TEMPLATEPATH."/l_sidebar.php");?>

<div id="contentmiddle">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
		<h2><?php the_title(); ?></h2>
		<div class="entry-content"><?php the_content(__('続きを読む'));?></div>
		<!--<?php trackback_rdf(); ?>-->
	</div><?php // #post-ID ?>

<?php endwhile; else: ?>
	<p><?php _e('お探しのページは見つかりませんでした。'); ?></p><?php endif; ?>
</div><?php // #contentmiddle ?>
	
</div><?php // #content ?>
<?php get_footer(); ?>
