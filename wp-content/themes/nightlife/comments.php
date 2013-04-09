<?php // このコードを削除しないでください。
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('このページを直接読み込まないでください。');
	if ( post_password_required() ) { ?><p class="nocomments">このコメントはパスワードで保護されています。表示するには、パスワードを入力してください。</p>
<?php return; } /* ここから編集が可能です。 */ ?>

<div id="commentblock">

<div id="comments">
	<?php if ( have_comments() ) { ?>
	<h3><?php comments_number('コメント（0）', 'コメント（1）', 'コメント（%）');?> &#8220;<?php the_title(); ?>&#8221;</h3>
		<ol class="commentlist">  
		<?php wp_list_comments('callback=list_comments'); ?>  
		</ol>
		<div class="comment-navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
	<?php } else { // コメントがない場合 ?>
		<?php if ('open' == $post->comment_status) { ?>
			<!-- コメントを受け付けていて、コメント数が0の場合 -->
		 <?php } else { // コメントを受け付けていない場合 ?>
			<!-- コメントを受け付けていない場合 -->
			<p class="nocomments">コメントを受け付けておりません。</p>
		<?php } ?>
	<?php } // end if have_comments ?>
</div><!-- #comments -->

<?php if ('open' == $post->comment_status) : ?>
<div id="respond">
	<h3><?php comment_form_title('コメントする', '%s にコメントする'); ?> <span class="cancel-comment-reply"><?php cancel_comment_reply_link('(キャンセル)'); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>コメントを投稿するには、 <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">ログイン</a> する必要があります。</p>
<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( $user_ID ) : ?>

	<p><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>としてログイン中。 <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="ログアウト">ログアウト &raquo;</a></p>

	<?php else : ?>

	<p><label for="author">お名前 <?php if ($req) echo "(必須)"; ?></label><br />
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" /></p>
	<p><label for="email">メールアドレス<?php if ($req) echo "(必須)"; ?></label><br />
	<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" /></p>
	<p><label for="url">ウェブサイト</label><br />
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" /></p>

	<?php endif; ?>

	<!--<p><small><strong>XHTML:</strong> 使用可能なタグ : <?php echo allowed_tags(); ?></small></p>-->

	<p><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></p>

	<p><?php comment_id_fields(); ?><input name="submit" type="submit" id="submit" tabindex="5" value="送信" /></p>

	<?php do_action('comment_form', $post->ID); ?>

	</form>

</div><!-- #respond -->
<?php endif; // ログインまたは登録が必要な場合 ?>

</div><!-- #commentblock -->
<?php endif; // このコードを削除しないでください。 ?>