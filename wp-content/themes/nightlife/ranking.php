<?php
$url = preg_split('/\//',$_SERVER['REQUEST_URI']);
$responses = get_ranking_info_from_key( $url[2], 10 );
$response = $responses[0]['items'];
?>

<?php get_header(); ?>
<div id="content_gp_middle">
  <div id="content_gp_top">
    <div id="content">
	  <div class="gp_tb13">
        <form method="GET" action="<?php echo get_settings('home'); ?>">
        <input class="gp_tb11" type="text" name="s" placeholder="プレゼントしたい人の名前を入力してください">
        <input class="gp_tb12" type="submit" value="検索">
        </form>
        <a href="/fb/"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_facebook_l.jpg" alt="Facebook" width="25px" height="25px"></a>
      </div> 
      <!-- <div class="gp_social_wg"><?php echo get_the_social_widgets();?></div> -->
 
	  <div class="gp_top_main">

	  <?php $loop_no = 1; ?>
      <?php foreach( $responses as $response): ?>

    <script type="text/javascript">
    $(document).ready(function(){
        $("#my-als-list-<?php echo $loop_no; ?>").als({
                    visible_items: 5,
                    scrolling_items: 3,
                    orientation: "horizontal",
                    circular: "no",
                    autoscroll: "no",
        });
    });
    </script>

      <div class="gp_title_page"><h2><?php echo $response['genre']; ?></h2></div>

	<div id="lista1">
	  <div class="als-container" id="my-als-list-<?php echo $loop_no; ?>">
	    <span class="als-prev"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_thin_left_arrow.png" alt="prev" title="previous" /></span>

	    <div class="als-viewport">
	      <?php $items = $response['items']; ?>
	      <ul class="als-wrapper">

		<?php foreach ($items as $item_tmp): ?>
		<?php $item = $item_tmp['Item']; ?>
		<?php if (!empty($item['smallImageUrls'][0]['imageUrl'])): ?>
		<li class="als-item gp_top_main_sub">
		  <div id="lista2">
		    <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>" target="_blank"><img src="<?php echo h($item['mediumImageUrls'][0]['imageUrl']) ?>"></a>
		    <?php endif; ?>
		    <?php echo '<div class="starlevel5 star' . sprintf('%02d',floor($item['reviewAverage']*2)*5) . '"></div>' ?>
		    <!--<li class="addbookmark"><a href="bookmark.php?itemCode=<?php echo h($item['itemCode']) ?>&amp;keyword=<?php echo h($keyword) ?>&amp;page=<?php echo h($page) ?>">ブックマークへ追加</a></li>-->
		    <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" title="<?php echo h($item['itemName']) ?>" target="_blank"><?php echo h(mb_strimwidth($item['itemName'], 0, 30, '...', 'UTF-8')) ?></a>
		    <p><?php echo h(number_format($item['itemPrice'])) ?>円</p>
		    <p>[ <a href="<?php echo h($item['affiliateUrl']) ?>" class="itemname" target="_blank">詳細はこちら</a> ]</p>
			<br/><br/>
		  </div>
	    </li>
		<?php endforeach; ?>

	      </ul>
	      <!--<hr size="0.7px" noshade />-->
	    </div>

	    <span class="als-next"><img src="<?php echo get_settings('home'); ?>/wp-content/themes/nightlife/images_gift/gp_thin_right_arrow.png" alt="next" title="next" /></span><!-- "next" button -->
	  </div><!-- my-als-list -->
	</div><!-- lista1 -->

	  <?php $loop_no = $loop_no + 1;?>
	  <?php endforeach; ?>

	  </div><!-- gp_top_main -->
    </div><!-- content -->
  </div><!-- content_gp_top -->
</div><!-- content_gp_middle -->
</div><!-- wrap -->
<?php get_footer(); ?>
