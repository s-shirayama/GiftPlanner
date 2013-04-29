<?php
/*
Plugin Name: Social Metrics
Plugin URI: http://www.riyaz.net/social-metrics/
Description: Track how your blog is doing across the leading social networking websites and services like Twitter, Facebook, Google +1, StumbleUpon, Digg and LinkedIn.
Author: Riyaz
Version: 2.2
Author URI: http://www.riyaz.net
License: GPL2
*/

/*  Copyright 2010  Riyaz Sayyad  (email : riyaz@riyaz.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
function socialmetrics_init() { ?>
<?php }
add_action('init', 'socialmetrics_init');
?>
<?php
function add_socialmetrics_scripts(){ ?>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
	<script type="text/javascript">
		(function() {
		  var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
		  s.type = 'text/javascript';
		  s.async = true;
		  s.src = 'http://widgets.digg.com/buttons.js';
		  s1.parentNode.insertBefore(s, s1);
		})();
	</script>
	<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
<?php
}
?>
<?php
/* function add_socialmetrics_settings_scripts(){ 
if ((is_admin() && $_GET['page'] == 'socialmetrics_settings') || (is_admin() && $_GET['page'] == 'socialmetrics_dashboard') || (is_admin() && substr($_SERVER['REQUEST_URI'], strlen($_SERVER['REQUEST_URI'])-9, strlen($_SERVER['REQUEST_URI']))== 'index.php')) { ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo plugins_url() . '/social-metrics/lib/jquery.qtip.pack.js'; ?>"></script>
<?php
	}
}
add_action('wp_print_scripts','add_socialmetrics_settings_scripts'); */

//function add_socialmetrics_settings_scripts(){ 
	//if ( ( is_admin( ) && $_GET['page'] == 'socialmetrics_settings') || ( is_admin( ) && $_GET['page'] == 'socialmetrics_dashboard' ) ) { 
		
		/* wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
		wp_enqueue_script('jquery');		
		
		wp_register_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js');
		wp_enqueue_script('jquery-ui'); */
		
		/* wp_register_script('jquery-qtip', plugins_url() . '/social-metrics/lib/jquery.qtip.pack.js' );
		wp_enqueue_script('jquery-qtip'); */
	//}
//}
//add_action('admin_enqueue_scripts','add_socialmetrics_settings_scripts');
?>
<?php
function add_socialmetrics_styles(){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url() . '/social-metrics/style.css'; ?>" />
<?php
}
?>
<?php
// create custom plugin settings menu
add_action('admin_menu', 'socialmetrics_create_menu');
function socialmetrics_create_menu() {
	//create new top-level menu
	add_menu_page( 'Social Metrics', 'Social Metrics', 'administrator', 'socialmetrics_dashboard', 'socialmetrics_dashboard_page', plugins_url() . '/social-metrics/images/sm-logo-20.png',3 );
	//add_submenu_page( 'index.php', 'Social Metrics', 'Social Metrics', 'administrator', 'socialmetrics_dashboard', 'socialmetrics_dashboard_page' );

	add_submenu_page('socialmetrics_dashboard', 'Social Metrics Settings', 'Settings', 'administrator', 'socialmetrics_settings', 'socialmetrics_settings_page' );
	//add_submenu_page('plugins.php', 'Social Metrics Settings', 'Settings', 'administrator', 'socialmetrics_settings', 'socialmetrics_settings_page' );
	//call register settings function
	add_action( 'admin_init', 'register_socialmetrics_settings' );
}

function socialmetrics_adminbar() {
	global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }
	$href = add_query_arg( 'page', 'socialmetrics_dashboard', admin_url() );
    $wp_admin_bar->add_menu( array(
    'id' => 'socialmetrics_dashboard',
    'title' => __( 'Social Metrics', 'socialmetrics_dashboard' ),
    'href' => $href ) );
}
add_action( 'admin_bar_menu', 'socialmetrics_adminbar', 100 );

function register_socialmetrics_settings() {
	//register the settings
	register_setting( 'socialmetrics-settings-group', 'socialmetrics_per_page' );
}

function socialmetrics_dashboard_page() {
add_socialmetrics_styles();
if ( !isset($_GET['p_type']) ) { $post_type = 'post'; }
elseif ( in_array( $_GET['p_type'], get_post_types( array('show_ui' => true ) ) ) ) {
	$post_type = $_GET['p_type']; }
else {
	wp_die( __('Invalid post type') ); }

$_GET['p_type'] = $post_type;

/*$post_type_object = get_post_type_object($post_type);*/

/* <script>
$(document).ready(function() {
	var shared = {
		position: {
			my: 'bottom center', 
			at: 'top center'
		},
		style: {
			classes: 'ui-tooltip-smblue ui-tooltip-shadow ui-tooltip-rounded'
		}
	};
	
	$( ".smwrap .tablenav *" ).qtip( $.extend({}, shared, {
	content: {
		attr: 'title'
	}
	
	}));
});
</script> */
?>
<div class="wrap">
<div class="smwrap">
	<h2 class="sm-branding">Social Metrics Dashboard: <?php bloginfo('name'); ?></h2>
	<div class="tablenav"><div style="float:left;margin:5px 5px 5px 0px;vertical-align: middle;">Metrics That Count | By <a style="text-decoration:none;"href="http://www.riyaz.net" target="_blank">riyaz.net</a></div>
	<div class="tablenav-pages"><a href="http://twitter.com/share?url=http://www.riyaz.net/social-metrics/&text=I am using the Social Metrics plugin to track how's my blog doing across Social Media Networks&via=riyaznet&related=riyaznet" target="_blank">Like what you see? Tweet about it!</a></div>
	</div>
<?php
	$per_page = get_option('socialmetrics_per_page', 15);
	if ( $per_page == 0 ) { $per_page = 15; }

	$paged = $_GET['paged'];
	$s_cat = $_GET['s_cat'];

	if (isset( $_GET['s_mon'] )) {
		$s_mon = $_GET['s_mon'];
		if (strlen($s_mon) == 6) {
		$s_month = substr($s_mon,4,6);
		$s_year = substr($s_mon,0,4);
		}
	}

	$pagenum = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 0;
	if ( empty($pagenum) ){ $pagenum = 1; }
	
    $recentPosts = new WP_Query();

	if ( 'post' != $post_type ) {
		$current_ptype = 'Pages';
		$recentPosts->query('showposts='.$per_page.'&post_status=publish'.'&paged='.$paged.'&post_type=page'.'&year='. $s_year . '&monthnum='.$s_month );
	}else {
		$current_ptype = 'Posts';
		$recentPosts->query('showposts='.$per_page.'&post_status=publish'.'&paged='.$paged.'&cat='.$s_cat.'&year='. $s_year . '&monthnum='.$s_month );
	}
?>
	<div class="tablenav">
<?php
		$num_pages = $recentPosts->max_num_pages;	
?>
<?php
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'prev_text' => __('&laquo;'),
			'next_text' => __('&raquo;'),
			'total' => $num_pages,
			'current' => $pagenum
		));
?>
		<div class="tablenav-pages" style="float: left;">
<?php 
			$s_uri = $_SERVER['REQUEST_URI']; 
			$s_uri = esc_url(remove_query_arg(array('paged','p_type','s_cat','s_mon'), $s_uri ));
?>
			<a href="<?php echo esc_url(add_query_arg('p_type', 'post', $s_uri )) ?>"><span class="page-numbers">Show All Posts</span></a>
			<a href="<?php echo esc_url(add_query_arg('p_type', 'page', $s_uri )) ?>"><span class="page-numbers">Show All Pages</span></a>	
<?php 
			$s_uri = $_SERVER['REQUEST_URI']; 
			$s_uri = remove_query_arg(array('paged','p_type','s_cat'), $s_uri );
			$s_uri = add_query_arg('page', 'socialmetrics_dashboard', $s_uri );

			if ( is_object_in_taxonomy($post_type, 'category') && ( 'post' == $post_type ) ) {
				$dropdown_options = array('show_option_none' => __('Filter by category'), 'hide_empty' => 0, 'hierarchical' => 1,'show_count' => 0, 'orderby' => 'name', 'selected' => $s_cat);
				wp_dropdown_categories($dropdown_options); ?>
				<script type="text/javascript"><!--
				var dropdown = document.getElementById("cat");
				function onCatChange() {
					if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
						location.href = "<?php echo $s_uri ?>&s_cat="+dropdown.options[dropdown.selectedIndex].value;
					}
				}
				dropdown.onchange = onCatChange;
				--></script>
<?php		} ?>
<?php 
			global $wpdb;
			global $wp_locale;

			if ( !is_singular() ) {
				$s_uri = $_SERVER['REQUEST_URI']; 
				$s_uri = remove_query_arg(array('paged','s_mon'), $s_uri );
				$s_uri = add_query_arg('page', 'socialmetrics_dashboard', $s_uri );

				$arc_query = $wpdb->prepare("SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM $wpdb->posts WHERE post_type = %s ORDER BY post_date DESC", $post_type);
				$arc_result = $wpdb->get_results( $arc_query );
				$month_count = count($arc_result);

				if ( $month_count && !( 1 == $month_count && 0 == $arc_result[0]->mmonth ) ) {
					$m = isset($_GET['s_mon']) ? (int)$_GET['s_mon'] : 0;
?>
					<select name='m' id='m'>
						<option<?php selected( $m, 0 ); ?> value='0'><?php _e('Filter by date'); ?></option>
<?php
						foreach ($arc_result as $arc_row) {
							if ( $arc_row->yyear == 0 ) { continue; }
							$arc_row->mmonth = zeroise( $arc_row->mmonth, 2 );

							if ( $arc_row->yyear . $arc_row->mmonth == $m ) {
								$default = ' selected="selected"'; }
							else {
								$default = ''; }

							echo "<option$default value='" . esc_attr("$arc_row->yyear$arc_row->mmonth") . "'>";
							echo $wp_locale->get_month($arc_row->mmonth) . " $arc_row->yyear";
							echo "</option>\n";
						}
?>					</select>
					<script type="text/javascript"><!--
					var dropdown_m = document.getElementById("m");
					function onMonthChange() {
						if ( dropdown_m.options[dropdown_m.selectedIndex].value > 0 ) {
							location.href = "<?php echo $s_uri ?>&s_mon="+dropdown_m.options[dropdown_m.selectedIndex].value;
						}
					}
					dropdown_m.onchange = onMonthChange;
					--></script>
<?php 			} ?>
<?php 		} ?>
			<div class="smpro-welcome"><a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank"><img src="<?php echo plugins_url() . '/social-metrics/images/pro-logo-20.png';?>"> <?php _e( 'Upgrade to Social Metrics Pro and enjoy more control', 'smpro' );?></a></div>
			<div class="smpro-settings"><a title="Change Settings" class="th-sort-t sm-export" href="<?php echo admin_url(); ?>admin.php?page=socialmetrics_settings"><img src="<?php echo plugins_url() . '/social-metrics/images/options.png';?>"></a></div>
		</div>
		<div class="tablenav-pages">
<?php 		if ( $page_links ) { ?>
<?php
				$count_posts = $recentPosts->found_posts;
				$page_links_text = sprintf( '<span class="displaying-num">' . __( '%s %s&#8211;%s of %s' ) . '</span>%s',
									$current_ptype,
									number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
									number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
									number_format_i18n( $count_posts ),
									$page_links
									);
				echo $page_links_text;
			}
?>
		</div>
	</div>	
	<div class="clear"></div>
	<table class="widefat post fixed smtable" cellspacing="0">
		<thead> 
			<tr>
				<th scope="col" id="title0" class="manage-column column-title" >Title</th>
				<th scope="col" id="title1" class="manage-column column-title" >Twitter</th>
				<th scope="col" id="title2" class="manage-column column-title" >Facebook</th>
				<th scope="col" id="title3" class="manage-column column-title" >Google +1</th>
				<th scope="col" id="title5" class="manage-column column-title" >StumbleUpon</th>
				<th scope="col" id="title6" class="manage-column column-title" >Digg</th>
				<th scope="col" id="title7" class="manage-column column-title" >LinkedIn</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td ><a href="/" target="_blank" rel="bookmark">トップページ</a></td>
				<td ><a href="http://twitter.com/share" class="twitter-share-button" data-text="トップページ" data-count="horizontal" data-url="http://<?php echo $_SERVER["HTTP_HOST"] ?>/">Tweet</a></td>
				<td ><iframe src="http://www.facebook.com/plugins/like.php?href=http://<?php echo $_SERVER["HTTP_HOST"] ?>/&send=false&layout=button_count&width=100&show_faces=false&action=like&colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></td>
				<td ><g:plusone size="medium" href="http://<?php echo $_SERVER["HTTP_HOST"] ?>/"></g:plusone></td>
				<td ><script src="http://www.stumbleupon.com/hostedbadge.php?s=1&r=http://<?php echo $_SERVER["HTTP_HOST"] ?>/"></script></td>
				<td ><a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=http://<?php echo $_SERVER["HTTP_HOST"] ?>/&amp;title=トップページ"></a></td>
				<td ><script type="in/share" data-url="http://<?php echo $_SERVER["HTTP_HOST"] ?>/" data-counter="right"></script></td>
			</tr>
<?php 		while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
			<tr>
				<td ><a href="<?php the_permalink() ?>" target="_blank" rel="bookmark"><?php the_title(); ?></a></td>
				<td ><a href="http://twitter.com/share" class="twitter-share-button" data-text="<?php the_title(); ?>" data-count="horizontal" data-url="<?php the_permalink() ?>">Tweet</a></td>
				<td ><iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&send=false&layout=button_count&width=100&show_faces=false&action=like&colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></td>
				<td ><g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone></td>
				<td ><script src="http://www.stumbleupon.com/hostedbadge.php?s=1&r=<?php the_permalink(); ?>"></script></td>
				<td ><a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"></a></td>
				<td ><script type="in/share" data-url="<?php the_permalink(); ?>" data-counter="right"></script></td>
			</tr>
<?php		endwhile; ?>
		</tbody>
		<tfoot>
			<tr> 
				<th scope="col"  class="manage-column column-title" >Title</th>
				<th scope="col"  class="manage-column column-title" >Twitter</th>
				<th scope="col"  class="manage-column column-title" >Facebook</th>
				<th scope="col"  class="manage-column column-title" >Google +1</th>
				<th scope="col"  class="manage-column column-title" >StumbleUpon</th>
				<th scope="col"  class="manage-column column-title" >Digg</th>
				<th scope="col"  class="manage-column column-title" >LinkedIn</th>
			</tr>
		</tfoot>

	</table>
	<div class="tablenav">
		<div class="tablenav-pages" style="float:left">
			<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Friyaznet&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:30px;" allowTransparency="true"></iframe>
			<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=riyaznet&show_count=true" style="width:300px; height:30px;"></iframe>
		</div>
		<div class="tablenav-pages">
<?php 		if ( $page_links ) { 
				$count_posts = $recentPosts->found_posts;
				$page_links_text = sprintf( '<span class="displaying-num">' . __( '%s %s&#8211;%s of %s' ) . '</span>%s',
									$current_ptype,
									number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
									number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
									number_format_i18n( $count_posts ),
									$page_links
									);
				echo $page_links_text;
			} ?>
		</div>
	</div>
</div>
</div>
<?php
add_socialmetrics_scripts();
}

function socialmetrics_settings_page() {
add_socialmetrics_styles();
?>
<div class="wrap">
<div class="smwrap">
	<h2 class="sm-branding">Social Metrics Settings</h2>
	<?php
	global $wp_query;
	$adm_url = admin_url();
	
	if( $_GET['updated'] ) { ?>
		<div id="message" class="updated">You are all set! Go to your <a href="<?php echo $adm_url . 'admin.php?page=socialmetrics_dashboard' ; ?>">Social Metrics Dashboard</a>.</div>
	<?php } ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'socialmetrics-settings-group' ); ?>
		<div style="min-width:940px;">
		<div style="float:left;min-width:600px;margin:10px 5px 10px 0px; padding:5px;">
			<h3>Choose Display Options</h3>
				<table class="form-table">
					<tr valign="top">
						<td style="width:230px;">Number of Posts to Display at a time</td>
						<td><input type="text" name="socialmetrics_per_page" value="<?php echo get_option('socialmetrics_per_page', 15); ?>" style="width: 50px;" />
						<br><div><span class="description">Here you can set the maximum number of posts to be displayed at a time. If no value is specified, default value 15 will be used. Keep this number less than 100 as high values may cause the Social Metrics Dashboard page to load at a slower pace. The <a title="Learn more about Social Metrics Pro" href="http://www.riyaz.net/social-metrics-pro/" target="_blank">Pro</a> version does not have this limitation.</span></div>
						</td>
					</tr>
				</table>
			<p class="sm-button-element">
				<button class="button-primary"><?php _e('Save Changes') ?></button>
			</p>
			<div class="smpro-welcome-settings">
				<h2>Social Metrics Pro gives you more control</h2>
				<div class="home-feature-section">
					<div class="pro-features">
						<div id="text-12" class="feature_box odd">
							<div class="feature-wrap"><h3 class="feature_title">Track Social Signals You Care About</h3>
								<div class="feature_text"><img class="features alignleft" src="http://socialmetricspro.com/wp-content/themes/optimal/images/custom/social-signals.png">Powerful Dashboard to centrally monitor social activity across leading social media networks like <em>Twitter, Facebook, Google+, Pinterest, StumbleUpon, Digg and LinkedIn</em>. You choose which networks you wish to track.
									<p></p><center><a href="http://www.riyaz.net/social-metrics-pro/" target="_blank" class="button-secondary">Learn More</a></center><p></p>
								</div>
							</div>
						</div>
						<div id="text-15" class="feature_box even">
							<div class="feature-wrap"><h3 class="feature_title">Sort, Search, Filter the Way You Want</h3>
								<div class="feature_text"><img class="alignleft" src="http://socialmetricspro.com/wp-content/themes/optimal/images/custom/sort-search-filter.png">Sort your data to identify which posts are performing best on which social networks. Perform keyword searches to study posts related to certain topics. Filter by post type, category, publishing date or by post authors.
									<p></p><center><a href="http://www.riyaz.net/social-metrics-pro/" target="_blank" class="button-secondary">Learn More</a></center><p></p>
								</div>
							</div>
						</div>
						<div id="text-11" class="feature_box odd">
							<div class="feature-wrap"><h3 class="feature_title">Colors to Indicate Relative Popularity</h3>
								<div class="feature_text"><img class="features alignleft" src="http://socialmetricspro.com/wp-content/themes/optimal/images/custom/reds-greens.png">Social Metrics Pro sports Excel-like conditional formatting. Posts with highest number of shares show up green. Posts with low social media activity show up amber and red. Turn reds to greens and you are on your way to social media success.
									<p></p><center><a href="http://www.riyaz.net/social-metrics-pro/" target="_blank" class="button-secondary">Learn More</a></center><p></p>
								</div>
							</div>
						</div>
						<div id="text-14" class="feature_box even">
							<div class="feature-wrap"><h3 class="feature_title">Export to Excel for Further Analysis</h3>
								<div class="feature_text"><img class="features alignleft" src="http://socialmetricspro.com/wp-content/themes/optimal/images/custom/export-excel.png">Social Metrics Pro lets you export the filtered, sorted data and custom queries to Excel. Youll get data in tab-delimited and comma-separated file formats. You can use Excel or any spreadsheet processor of your choice.
									<p></p><center><a href="http://www.riyaz.net/social-metrics-pro/" target="_blank" class="button-secondary">Learn More</a></center><p></p>
								</div>
							</div>
						</div>
						<div id="text-13" class="feature_box odd">
							<div class="feature-wrap"><h3 class="feature_title">Widgets and Extensions Ready</h3>
								<div class="feature_text"><img class="features alignleft" src="http://socialmetricspro.com/wp-content/themes/optimal/images/custom/plugin-extensions.png">You can extend the functionality by using built-in and external widgets. See latest stats on your WordPress dashboard, Access the dashboard from WordPress admin bar and even display your socially popular content on your blog sidebar or anywhere on your site.
									<p></p><center><a href="http://www.riyaz.net/social-metrics-pro/" target="_blank" class="button-secondary">Learn More</a></center><p></p>
								</div>
							</div>
						</div>
						<div id="text-16" class="feature_box even">
							<div class="feature-wrap"><h3 class="feature_title">Auto-update Capable</h3>
								<div class="feature_text"><img class="features alignleft" src="http://socialmetricspro.com/wp-content/themes/optimal/images/custom/wp-autoupdate.png">Social Metrics Pro supports 1-click auto-update functionality. You can update your Social Metrics Pro in a single click via WordPress Updates page, or update it manually if you like. You can optionally choose to receive an email notification whenever a new version is released.
									<p></p><center><a href="http://www.riyaz.net/social-metrics-pro/" target="_blank" class="button-secondary">Learn More</a></center><p></p>
								</div>
							</div>
						</div>
					</div><!-- end .pro-features -->
				</div>
				<h3>Need Help?</h3>
				For Help, Support, Bugs, Feedback, Suggestions, Feature requests, please visit <a href="http://www.riyaz.net/social-metrics/" style="text-decoration:none;" target="_blank">Social Metrics Homepage</a> or reach me through <a href="http://www.riyaz.net/contact/" target="_blank" style="text-decoration:none;">contact options</a>.
				<h3>Who Created the	Social Metrics?</h3>
				<div>The <a href="http://www.riyaz.net/social-metrics/" target="_blank" style="text-decoration:none;font-weight:bold;">Social Metrics</a> plugin for WordPress is created by <a href="http://www.riyaz.net/about/" target="_blank" style="text-decoration:none;">Riyaz</a>. Riyaz blogs at <a href="http://www.riyaz.net" target="_blank" style="text-decoration:none;font-weight:bold;">riyaz.net</a>.<br></br></div>
				<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/follow_button.html?screen_name=riyaznet&show_count=true" style="width:300px; height:20px;"></iframe>
				<br><br><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Friyaznet&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=30" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:30px;" allowTransparency="true"></iframe>
				<br><script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
				<g:plusone size="medium" href="http://www.riyaz.net/"></g:plusone>
			</div>
		</div>
	</form>
</div>
</div>
<?php } ?>
