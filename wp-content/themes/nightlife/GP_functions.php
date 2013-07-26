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

/*
* プレゼントカテゴリー情報取得関数
* Auth: Shiotsuka
* 引数: $key
*/
function get_gp_category_info_from_key($key) {
  $res = mysql_query("select cat_name,cat_description,cat_image from gp_category_mst where key_name = '$key'");
  if (!$res) {
	echo 'Could not run query: ' . mysql_error();
	exit;
  }
  else {
    $result = mysql_fetch_row($res);
  return $result; 
  } }
?>
