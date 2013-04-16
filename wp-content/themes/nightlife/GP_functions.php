<?php
/*
* 記事フィード関数
* Auth: Shiotsuka
* 引数: $cat_name = カテゴリ名
*       $num_feed = 取得記事数
*/
function kiji_feed($cat_name,$num_feed) {
 $cat_id = get_cat_ID($cat_name);
 $posts = get_posts("numberposts='.$num_feed.'&category='.$cat_id");
 return $posts; }
?>
