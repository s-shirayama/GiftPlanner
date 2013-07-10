<?php get_header(); ?>
<div id="content_gp_middle">
  <div id="content_gp_top">
    <div id="content">
      <?php //include(TEMPLATEPATH."/l_sidebar.php");?>

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      
      <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
      <div class="gp_title_page">
		<h2><?php the_title(); ?></h2>
      </div>
      <div class="entry-content"><?php the_content(__('続きを読む'));?></div>
      <!--<?php trackback_rdf(); ?>-->
      </div><?php // #post-ID ?>

      <?php endwhile; else: ?>
      <p><?php _e('お探しのページは見つかりませんでした。'); ?></p><?php endif; ?>
      </div><?php // #content ?>
    </div><!-- #content_gp_middle -->
  </div><!-- #content_gp_top -->
</div><!-- #wrap -->
<?php get_footer(); ?>
