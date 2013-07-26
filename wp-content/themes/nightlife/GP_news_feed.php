<ul class="gp_margin_1">
<?php
 /*include 'GP_functions.php';*/
 $posts = kiji_feed('ニュース',5);
 global $post;
?>
<?php if($posts): foreach($posts as $post): setup_postdata($post); ?>
<li class="gift_line2">
  <?php the_time('Y-m-d'); ?> 
  :
  <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
</li>
<?php endforeach; endif; ?>
</ul>
