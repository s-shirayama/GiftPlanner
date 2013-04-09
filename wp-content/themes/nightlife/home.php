<?php get_header(); ?>
<div id="content">

<?php /* ?>
<?php include(TEMPLATEPATH."/l_sidebar.php");?>
<?php */ ?>

<div id="contentmiddle">

<h1>名前を入力すると、 GiftPlanner がプレゼントを探してきます！</h1>

<div id="gift_style_main">

<form method="GET">

 <div class="gift_style1">
  <input type="text" name="s"/> さんへのプレゼント
  <input type="submit" value="を探す！" />
 </div>

</form>

</div>

<div id="gift_brank"></div>

<!--<ul><?php get_archives('postbypost', 5); ?></ul>-->

</div><!-- #contentmiddle -->
	
</div><!-- #content -->

<?php get_footer(); ?>
