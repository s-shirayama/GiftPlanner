<?php get_header(); ?>
<div id="content_gp_middle">
  <div id="content_gp_top">
    <div id="content">

      <div class="gp_social_wg">
	<?php echo get_the_social_widgets(); ?>
      </div>
      <div class="gp_title">
	<h2>名前でプレゼントが検索できる！ギフトプランナー</h2>
      </div>
      <div class="gp_top_main">

	<h3>他にない、プレゼント探し</h3>
	<div class="gp_top_main_desc">
	  <p>ギフトプランナーは名前でその人にあったプレゼントを見つけることができる検索サービスです。</p>
	  <p>検索方法は簡単。あなたがプレゼントしたい人の名前を入力するだけ。ぜひ、お試しください。</p>
	  <p>[より便利に]<br/>FaceBookアカウントをお持ちであれば、FaceBook上でつながっている友達から検索できます。通常検索よりも、その人によりピッタリなプレゼントが探せます。</p>
	</div>
	<div class="gp_top_main_search">
	<h4>名前でプレゼント検索</h4>
	  <form method="GET" style="text-align:right;">
	    <input class="gp_tb11" type="text" name="s" placeholder="プレゼントしたい人の名前を入力してください"/>
	    <br/>さんへのプレゼントを
	    <input class="gp_tb12" type="submit" value="検索する" />
	  </form>
	<br/>
	<h4>ソーシャルサービスへのログイン</h4>
    <p><a href="/fb/"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_facebook_l.jpg" alt="Facebook" width="30px" height="30px"/></a>
	   <!--<a href="/tw/"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_twitter.jpg" alt="Twitter" width="30px" height="30px"/></a>-->
	</p>
	</div>

      </div><!-- gp_top_main -->

      <?php /* ?>
      <?php include(TEMPLATEPATH."/l_sidebar.php");?>
      <?php */ ?>

  <div class="gp_top_main">
	<h3>プレゼントカテゴリー</h3>
	<div class="gp_top_category">
	<?php include(TEMPLATEPATH."/GP_present_category.php"); ?>
	</div>
  </div><!-- gp_top_main -->

  <div class="gp_top_main">
    <h3>ギフトプランナー新着情報</h3>
    <?php /* ニュースカテゴリ記事新着 */ include 'GP_news_feed.php'; ?>
	<p style="margin-right:23px; text-align:right;">- 過去の情報は<a href="<?php echo get_settings('home');?>/category/ニュース">こちら</a> -</p>
  </div>

<?php /* include(TEMPLATEPATH."/sidemenu.php"); */ ?>

  <!--<ul><?php get_archives('postbypost', 5); ?></ul>-->

<!--</div>--><!-- #contentmiddle -->

</div><!-- #content -->
</div><!-- #content_gp_middle -->
</div><!-- #content_gp_top -->
</div><!-- #wrap -->
<?php get_footer(); ?>
