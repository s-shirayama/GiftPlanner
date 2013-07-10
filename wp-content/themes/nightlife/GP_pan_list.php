<?php if(!is_home()): ?>
<div id="gift_breadcrumb">
  <ul>
    <li><a href="<?php echo home_url(); ?>/">HOME</a></li>
    <li>-</li>
    <?php if(is_search()): /* 検索結果表示 */ ?>
    <li><?php echo $_GET["s"]; ?>　さんへのお勧めプレゼント！</li>

    <?php elseif(is_tag()): /* タグアーカイブ */?>

    <?php elseif(is_404()): /* 404 Not Found */?>
    <li>404 Not found</li>
    <?php elseif(is_date()): /* 日付アーカイブ */?>

    <?php elseif(is_category()): /* カテゴリーアーカイブ */?>
    <?php $cat = get_queried_object(); /* オブジェクトを取得 */ ?>
    <?php if($cat -> parent != 0): /* 親カテゴリーの有無 */?>
    <?php $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' )); /* 祖先カテゴリーの取得 */ ?>
    <?php foreach($ancestors as $ancestor): /* 親カテゴリーの数だけ繰り返し処理 */ ?>
    <li><a href="<?php echo get_category_link($ancestor); ?>"><?php echo get_cat_name($ancestor); ?></a></li>
    <li>-</li>
    <?php endforeach; ?>
    <?php endif; ?>
    <li><?php echo $cat -> cat_name; ?></li>

    <?php elseif(is_author()): /* 投稿者アーカイブ */?>

    <?php elseif(is_page()): /* 固定ページ */?>
    <?php if($post -> post_parent != 0 ): /* 親ページの有無 */ ?>
    <?php $ancestors = array_reverse( $post-> ancestors ); /* 祖先ページの ID を取得 */ ?>
    <?php foreach($ancestors as $ancestor): /* 祖先ページの数だけ繰り返し処理 */ ?>
    <li><a href="<?php echo get_permalink($ancestor); ?>"><?php echo get_the_title($ancestor); ?></a></li>
    <li>-</li>
    <?php endforeach; ?>
    <?php endif; ?>
    <li><?php echo $post -> post_title; ?></li>

    <?php elseif(is_attachment()): /* 添付ファイルページ */?>

    <?php elseif(is_single()): /* ブログ記事 */?>
    <?php $categories = get_the_category($post->ID); /* カテゴリーを取得 */ ?>
    <?php $cat = $categories[0]; /* 配列から最初のカテゴリーを取得 */ ?>
    <?php if($cat -> parent != 0): /* 親カテゴリーの有無 */ ?>
    <?php $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' )); /* 祖先カテゴリーを取得 */?>
    <?php foreach($ancestors as $ancestor): ?>
    <li><a href="<?php echo get_category_link($ancestor); ?>"><?php echo get_cat_name($ancestor); ?></a></li>
    <li>-</li>
    <?php endforeach; ?>
    <?php endif; ?>
    <li><a href="<?php echo get_category_link($cat -> cat_ID); ?>"><?php echo $cat-> cat_name; ?></a></li>
    <li>-</li>
    <li><?php echo $post -> post_title; ?></li>

    <?php else: /* 上記以外 */?>

    <?php endif; ?>
  </ul>
</div>
<?php endif; ?>
