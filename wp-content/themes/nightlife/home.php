<?php get_header(); ?>
<div id="content">

  <?php /* ?>
  <?php include(TEMPLATEPATH."/l_sidebar.php");?>
  <?php */ ?>

  <div id="contentmiddle">
    <?php
      echo get_the_social_widgets();
    ?>
    <h1>名前を入力すると、 GiftPlanner がプレゼントを探してきます！</h1>

    <div id="gift_style_main">

	<div class="gift_style1">
	  <form method="GET">
	  <input type="text" name="s"/> さんへのプレゼント
	  <input type="submit" value="を探す！" />
	  </form>
	</div>

	<div class="gift_style1">
	  <a href="/fb/"><button class="fb_button">Facebookの友達へのプレゼントを探す！</button></a>
	</div>



    </div>

    <div id="gift_brank"></div>

    <div style="text-align: center;">
      <h2>ギフトプランナー新着情報</h2>
      <?php
     /* ニュースカテゴリ記事新着 */
     include 'GP_news_feed.php';
?>
    </div>

    <!--<ul><?php get_archives('postbypost', 5); ?></ul>-->

  </div><!-- #contentmiddle -->
  
</div><!-- #content -->

<?php get_footer(); ?>
