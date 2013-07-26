<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="distribution" content="global" />
    <meta name="robots" content="follow, all" />
    <meta name="language" content="en, sv" />
    <title>
	<?php include 'GP_functions.php'; ?>
	<?php
		/* ランキングページ用 */
		$url = preg_split('/\//',$_SERVER['REQUEST_URI']);
		if($url[1]=='ranking') {
			$gp_category_mst = get_gp_category_info_from_key( $url[2] );
			echo $gp_category_mst[0] ?>に贈るプレゼント | ギフトプランナー;
		} else {
	?>
	<?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?><?php bloginfo('name'); }; ?>
	</title>
    <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /><!-- leave this for stats please -->
    <link rel="Shortcut Icon" href="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images/favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_get_archives('type=monthly&format=link'); ?>
    <?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>
    <?php wp_head(); ?>
    <style type="text/css" media="screen">
      <!-- @import url( <?php bloginfo('stylesheet_url'); ?> ); -->
    </style>
    <?php if ( $_SERVER['SERVER_PORT']=='80' ) { include_once("analyticstracking.php"); } ?>
	<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/jquery.als-1.1.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#my-als-list").als({
					visible_items: 5,
					scrolling_items: 3,
					orientation: "horizontal",
					circular: "no",
					autoscroll: "no",
		});
	});	
	</script>
  </head>
  <body>
	<!-- FaceBookウィジット用 START-->
	<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
	<!-- FaceBookウィジット用 END -->
	<div id="wrap">
    <?php /* h1生成 */ include 'GP_h1_gen.php'; ?>
    <div id="header">
      <div class="blogtitle">
	<a href="<?php echo get_settings('home'); ?>/"><?php // bloginfo('name'); ?><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_logo.png" alt="プレゼント選びのギフトプランナー" /></a>
      </div>
	  <div class="blogtitle2">
		<img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_img_allow.png" alt="" width="12px" height="12px" />
		<a href="<?php echo get_settings('home'); ?>/gp_howto">ご利用案内</a>
	  </div>
	<!-- <?php echo get_the_social_widgets(); ?> -->
	</div>

    <?php /* 一旦メニューはコメントアウト by Shirayama
		 <div id="navbar">
		 <ul>
		 <li><a href="<?php echo get_settings('home'); ?>">Home</a></li>
		 <?php wp_list_pages('title_li=&depth=1'); ?>
	       </ul>
	     </div>
	     */ ?>

	     <?php /* パンくず追加 by Shiotsuka */ include_once("GP_pan_list.php"); ?>
