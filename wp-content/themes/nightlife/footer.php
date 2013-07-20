<!-- begin footer -->

<!-- <div style="clear:both;"></div> -->
<!-- <div style="clear:both;"></div> -->

<div id="footer">
  <div id="gift_infobar">
    <div class="gift_footer_content">
      <p>ご紹介</p>
      <ul>
	<li><a href="<?php echo get_settings('home'); ?>/description">GiftPlanner でできること</a></li>
	<li><a href="<?php echo get_settings('home'); ?>/member">サイト運営者紹介</a></li>
	<li><a href="<?php echo get_settings('home'); ?>/category/開発者ブログ">開発者ブログ</a></li>
	<li><a href="<?php echo get_settings('home'); ?>/category/企画運営ブログ">企画運営ブログ</a></li>
	<li><a href="<?php echo get_settings('home'); ?>/sitemap">サイトマップ</a></li>
      </ul>
    </div>
    <div class="gift_footer_content">
      <p>月別アーカイブ</p>
      <ul><?php wp_get_archives('type=monthly&limit=12'); ?></ul>
    </div>
    <div class="gift_footer_content" style="width:300px;">
      <p>免責事項</p>
      <ul>
		<li>本サイトは個人名から極力最適なプレゼント・商品を検索するサービスです。当サイトの御利用につき、何らかのトラブル等が発生した場合でも一切責任を問わないものとします。</li>
	  </ul>
    </div>
  </div>

  <div id="gift_style2">
	Copyright &copy; <a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a>
  </div>
  <!--&bull; Nightlife theme by <a href="http://wpthemejp.com/">WordPress theme</a>-->
  <?php do_action('wp_footer'); ?>
</body>
