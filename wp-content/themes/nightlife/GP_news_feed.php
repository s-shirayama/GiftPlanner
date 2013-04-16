<ul>
<?php
 include 'GP_functions.php';
 $posts = kiji_feed('ニュース',5);
 global $post;
?>
<?php if($posts): foreach($posts as $post): setup_postdata($post); ?>
<li>
  <?php the_time('Y-m-d'); ?> 
  :
  <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
</li>
<?php endforeach; endif; ?>
</ul>
