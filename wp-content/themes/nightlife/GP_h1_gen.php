<?php if(is_home() || is_search()): /* トップページもしくは検索結果表示ページ*/ ?>

<h1>友達や彼氏・彼女の名前で検索！プレゼント探しするならギフトプランナー</h1>

<?php elseif(is_category()): /* カテゴリーアーカイブ */?>

<h1>ギフトプランナーでプレゼントを検索！友達、彼氏・彼女へのギフト選びのお手伝いサービス</h1>

<?php elseif(is_page()): /* 固定ページ */?>

<h1>ピッタリのプレゼントを簡単に探す！友達、家族、彼氏・彼女への贈り物にお勧めギフトプランナー</h1>

<?php elseif(is_single()): /* ブログ記事 */?>
<?php $categories = get_the_category($post->ID); /* カテゴリーを取得 */ ?>
<?php $cat = $categories[0]; /* 配列から最初のカテゴリーを取得 */ ?>
<?php if($cat -> parent != 0): /* 親カテゴリーの有無 */ ?>
<?php $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' )); /* 祖先カテゴリーを取得 */?>
<?php foreach($ancestors as $ancestor): ?>
<?php endforeach; ?>
<?php endif; ?>
<h1>プレゼント選びのギフトプランナーからお届け！<?php echo $cat-> cat_name; ?></h1>

<?php else: /* 上記以外 */?>

<h1>友達や彼氏・彼女の名前で検索！プレゼント探しするならギフトプランナー</h1>

<?php endif; ?>
