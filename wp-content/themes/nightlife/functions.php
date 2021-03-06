<?php
require_once (ABSPATH . WPINC . '/class-snoopy.php');

// 楽天API呼び出し用
require_once( WP_CONTENT_DIR . '/lib/rws-php-sdk-master/autoload.php' );

// FacebookAPI呼び出し用
require_once( WP_CONTENT_DIR . '/lib/facebook-php-sdk/src/facebook.php' );
$facebook = new Facebook(array('appId' => FB_APP_ID, 'secret' => FB_SECRET));

// HTML Escape
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// FacebookのIDに紐づく投稿情報を抽出する関数
function fbid2messages( $fbid ){
    global $facebook;
    $messages = array();
    try{
	// 友達の投稿情報を取得
	$fql = "SELECT message FROM status where uid = " . $fbid . " limit 3";
	$friend_info = $facebook->api(array(
					'method' => 'fql.query',
					'query' => $fql,
					    ));
	foreach( $friend_info as $finfo ){
	    $messages[] = $finfo['message'];
	}
	// 友達のチェックイン情報を取得
	$fql = "SELECT message FROM checkin where author_uid = " . $fbid . " limit 3";
	$friend_info = $facebook->api(array(
					'method' => 'fql.query',
					'query' => $fql,
					    ));
	foreach( $friend_info as $finfo ){
	    $message[] = $finfo['message'];
	}
	// 友達の写真情報を取得
	$fql = "SELECT caption FROM photo where owner = " . $fbid . " limit 3";
	$friend_info = $facebook->api(array(
					'method' => 'fql.query',
					'query' => $fql,
					    ));
	foreach( $friend_info as $finfo ){
	    $messages[] = $finfo['caption'];
	}
	
    } catch (FacebookApiException $e) {
	if (0) { // 開発中はここでエラー表示後に終了、0にするとFacebook提供サンプルと同じ処理に
	    echo $e;
	    exit;
	}
	error_log($e);
	$user = null;
    }
    return array_unique( $messages );
}

// 文章からキーワードを抽出する関数
function messages2keywords( $sentences ){
    $tmp_string = "";
    foreach( $sentences as $sentence ){
	$tmp_string .= $sentence . " ";
    }
    return sentences2keywords( $tmp_string );
}

// 名前からWEB記事に変換する関数
function name2messages( $name ){
	$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&restrict=countryJP&lr=lang_ja&"
		. "q=" . urlencode( $name );
	// note how referer is set manually
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	curl_setopt($ch, CURLOPT_URL, $url);

	// now, process the JSON string
	$json = json_decode( curl_exec($ch) );

	$start = rand( 0, min( 60, max( 0, intval($json->responseData->cursor->resultCount) - 4 )));

	$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&restrict=countryJP&lr=lang_ja&start=" . $start . "&"
		. "q=" . urlencode( $name );

	curl_setopt($ch, CURLOPT_URL, $url);
	// now, process the JSON string
	$json = json_decode( curl_exec($ch) );
	curl_close($ch);

	$messages = array();
	foreach( $json->responseData->results as $result ){
		$messages[] = $result->content;
	}

	return $messages;
}

// 日本語の文章からキーワードを抽出する関数
function sentences2keywords( $sentences ){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	curl_setopt($ch, CURLOPT_URL, $url);
	$url = "http://jlp.yahooapis.jp/KeyphraseService/V1/extract?appid="
	    . YH_APP_ID . "&output=json&sentence=" . urlencode( $sentences );
	curl_setopt($ch, CURLOPT_URL, $url);

	$json = json_decode( curl_exec($ch) );
	curl_close($ch);

	$keywords = remove_prohibition_keywords( array_keys( (array)$json ) );

	return $keywords;
}

// 引数で渡されたarrayから以下を取り除く
// ・英語の文
// ・$prohibition(引数)
function remove_prohibition_keywords( $keywords, $prohibition = '' ){
	$res = array();
	foreach( $keywords as $keyword ){
		if( preg_match( '/[a-zA-Z] [a-zA-Z]/', $keyword ) === 0 && 
				$keyword !== $prohibition ){
			array_push( $res, $keyword );
		}
	}
	return $res;
}

// 性別、年代、関係、何の日か
// の情報を元に、ジャンル情報を返す関数
function get_genres( $sex, $age, $relation, $category ){
	// 暫定で適当なロジックを追加
	// 20代、男性はネクタイ(502429)
	// 30代、女性は小物入れ(400770)
	if ( $sex === "0" && $age === "20" ){
		return '502429';
	} else if ( $sex === "1" && $age === "30" ){
		return '400770';
	} else {
		return;
	}
}

// キーワード、性別、年代、ジャンル、予算(MIN)、予算(MAX)
// の情報を元に、表示する商品情報を返す関数
function get_products_info( $keyword, $sex, $age, $genre, $min, $max ){

	$page      = 1;

	// Clientインスタンスを生成 Make client instance
	$rwsclient = new RakutenRws_Client();
	// アプリIDをセット Set Application ID
	$rwsclient->setApplicationId(RAKUTEN_APP_ID);
	// アフィリエイトIDをセット (任意) Set Affiliate ID (Optional)
	$rwsclient->setAffiliateId(RAKUTEN_APP_AFFILITE_ID);

	// 楽天市場商品検索API2 で商品を検索します
	// Search by IchibaItemSearch (http://webservice.rakuten.co.jp/api/ichibaitemsearch/)
	$api_arg = array();
	if ( $keyword && !$genre ) $api_arg = array_merge( $api_arg, array( 'keyword' => $keyword ) );
	$api_arg = array_merge( $api_arg, array( 'page'    => $page ) );
	$api_arg = array_merge( $api_arg, array( 'hits'    => 10 ) );
	$api_arg = array_merge( $api_arg, array( 'sort'    => '-reviewAverage' ) );
	$api_arg = array_merge( $api_arg, array( 'orFlag'    => '1' ) );
	if ( $genre ) $api_arg = array_merge( $api_arg, array( 'genreId' => $genre ) );
	if ( $min ) $api_arg = array_merge( $api_arg, array( 'minPrice'=> $min ) );
	if ( $max ) $api_arg = array_merge( $api_arg, array( 'maxPrice'=> $max ) );

	return $rwsclient->execute('IchibaItemSearch', $api_arg );
}

// ランキングの種類(key)からランキングマスタ情報の取得ー＞ランキング情報の取得
// 引数はkey情報、ランキングの件数
function get_ranking_info_from_key($key, $count){
    global $wpdb;
    $result = array();
    $res = $wpdb->get_results("select * from gp_ranking_mst where name = '" . $key . "' order by rank", ARRAY_A);
    foreach( $res as $rank_info ){
	$tmp = get_ranking( null, null, $rank_info['genreId'] )->getData();
	array_push( $result, array( 'items' => array_slice( $tmp['Items'], 0, $count ), 'genre' => $rank_info['genreName'] ));
    }
    return $result;
}

// 注目のキーワードを取得する関数
// 引数は取得件数、ランダムソートの有無
function get_notable_keyword( $num, $randomp ){
    global $wpdb;
    $result = array();
    $sort = $randomp ? "rand()" : "sort";
    $res = $wpdb->get_results("select keyword from gp_keyword_mst order by " . $sort . " limit " . $num, ARRAY_A);
    foreach( $res as $keyword_info ){
        array_push( $result, $keyword_info['keyword'] );
    }
    return $result;
}

// ランキング情報を取得する関数
// 引数は性別、年代、ジャンル
function get_ranking( $sex, $age, $genre ){
    // Clientインスタンスを生成
    $rwsclient = new RakutenRws_Client();
    $rwsclient->setApplicationId(RAKUTEN_APP_ID);
    $rwsclient->setAffiliateId(RAKUTEN_APP_AFFILITE_ID);
    
    // APIの引数をセット
    $api_arg = array();
    if ( $sex ) $api_arg = array_merge( $api_arg, array( 'sex'=> $sex ) );
    if ( $age ) $api_arg = array_merge( $api_arg, array( 'age'=> $age ) );
    if ( $genre ) $api_arg = array_merge( $api_arg, array( 'genreId' => $genre ) );
    
    return $rwsclient->execute('IchibaItemRanking', $api_arg );
}


if ( function_exists('register_sidebar') )
register_sidebar();

function list_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;  
	?>  
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"><div id="div-comment-<?php comment_ID(); ?>">
		<div class="comment-avatar"><?php echo get_avatar($comment, $size = '36'); ?></div>
		<div class="author comment-author vcard"><cite><?php comment_author_link() ?></cite></div>
		<div class="meta comment-meta commentmetadata"><a class="date" href="#comment-<?php comment_ID(); ?>" title="Permalink to this response"><?php comment_date('Y年m月d日'); echo "  "; comment_time(); ?></a><?php edit_comment_link('編集',' ',''); ?></div>
		<div class="commenttext">
		<?php if ($comment->comment_approved == '0') : ?><em>承認待ちのコメントです。</em><?php endif; ?>			
		<?php comment_text(); ?>
		<p class="reply"><?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
		</div>
		</div>
		<?php } // end list_comments()

		// オプションページの追加
		add_action ('admin_menu', 'k2menu');

		$k2loc = '../themes/' . basename(dirname($file)); 

		function k2menu() {
			add_submenu_page('themes.php', 'Nightlife Options', 'Nightlife Options', 5, $k2loc . 'functions.php', 'menu');
		}

function menu() {
	load_plugin_textdomain('k2options');
	//管理画面　開始
	?>

		<div class="wrap">

		<h2><?php _e('Nightlife'); ?></h2>

		<div class="wrap">
		Nightlife は <a href="http://www.briangardner.com">Brian Gardner</a> のデザインです。


		<h3>おすすめアフィリエイト</h3>
		<p><a href="http://www.text-link-ads.com/?ref=42218">Text Link Ads</a>
		<p><a href="https://midphase.com/newaff/index.cgi?s=&cmd=CreateAccount&myp=0.725394687921838">MidPhase Hosting Affiliate Program</a>
		<p><a href="http://www.reviewme.com">ReviewMe</a>

		<h3>おすすめブログ</h3>
		<p><a href="http://www.blogherald.com">The Blog Herald</a>
		<p><a href="http://www.901am.com">901am.com</a>
		<p><a href="http://tubetorial.com">Tubetorial</a>

		<h3>おすすめホスティングプロバイダ</h3>
		<p><a href="http://www.midphase.com/newaff/redir.pl?a=0.725394687921838&c=1&creative=Banners|midPhase|TextLinks|TextLink&redirURL=">MidPhase</a>.  

		</div>

		<?php } // 管理画面　終了 ?>
