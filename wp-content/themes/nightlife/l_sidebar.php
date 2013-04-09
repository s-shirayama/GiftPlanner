<!-- begin l_sidebar -->

	<div id="l_sidebar">
	<ul id="l_sidebarwidgeted">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
	<input type="text" class="search_input" value="キーワードを入力してください" name="s" id="s" onfocus="if (this.value == 'キーワードを入力してください') {this.value = '';}" onblur="if (this.value == '') {this.value = 'キーワードを入力してください';}" />
	<input type="hidden" id="searchsubmit" value="検索" />
</form><br />
	
	<li id="Recent">
	<h2>最新エントリー</h2>
		<ul>
		<?php get_archives('postbypost', 10); ?>
		</ul>
	</li>
	
	<li id="Categories">
	<h2>カテゴリー</h2>
		<ul>
		<?php wp_list_cats('sort_column=name'); ?>
		</ul>
	</li>
		
	<li id="Archives">
	<h2>アーカイブ</h2>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
		
	<li id="Blogroll">
	<h2>ブログロール</h2>
		<ul>
		<?php get_links(-1, '<li>', '</li>', ' - '); ?>
		</ul>
	</li>
		
	<li id="Admin">
	<h2>管理者ページ</h2>
		<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="http://www.wordpress.org/">Wordpress</a></li>
		<?php wp_meta(); ?>
		<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>
		</ul>
	</li>
		
		<?php endif; ?>
		</ul>
			
</div>

<!-- end l_sidebar -->