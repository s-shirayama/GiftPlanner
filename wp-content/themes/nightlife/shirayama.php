<?php

// 楽天API呼び出し用
require_once '/var/lib/php/rws-php-sdk-master/autoload.php';
require_once '/var/lib/php/rws-php-sdk-master/sample/config.php';
require_once '/var/lib/php/rws-php-sdk-master/sample/helper.php';

// 名前からキーワードに変換する関数
function name2keyword( $name ){
        return $name;
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

    // プロキシの設定が必要な場合は、ここで設定します。
    // If you want to set proxy, please set here.
    // $rwsclient->setProxy('proxy');

    // 楽天市場商品検索API2 で商品を検索します
    // Search by IchibaItemSearch (http://webservice.rakuten.co.jp/api/ichibaitemsearch/)

    $api_arg = array();
    if ( $keyword && !$genre ) $api_arg = array_merge( $api_arg, array( 'keyword' => $keyword ) );
    $api_arg = array_merge( $api_arg, array( 'page'    => $page ) );
    $api_arg = array_merge( $api_arg, array( 'hits'    => 3 ) );
    $api_arg = array_merge( $api_arg, array( 'sort'    => '-reviewAverage' ) );
    if ( $genre ) $api_arg = array_merge( $api_arg, array( 'genreId' => $genre ) );
    if ( $min ) $api_arg = array_merge( $api_arg, array( 'minPrice'=> $min ) );
    if ( $max ) $api_arg = array_merge( $api_arg, array( 'maxPrice'=> $max ) );

    return $rwsclient->execute('IchibaItemSearch', $api_arg );
}

function display( $response ){
  foreach ($response as $item):
  echo h(mb_strimwidth($item['itemName'], 0, 80, '...', 'UTF-8'));
  echo h(number_format($item['itemPrice'])) . "円";
  echo h(number_format($item['genreId'])) . " ";
  echo h(number_format($item['reviewAverage']));
  echo "\n";
  endforeach;
}

function test_get_products_info(){
        display( get_products_info( "時計", null, null, null, null, null) );
        display( get_products_info( "時計", null, null, null, 3000, 4000) );
        display( get_products_info( "時計", null, null, 302153, null, null) );
}

function test_get_genres(){
	echo get_genres(null,null,null,null) . "\n";
	echo get_genres("0","20",null,null) . "\n";
	echo get_genres("1","30",null,null) . "\n";
	echo get_genres("0",null,null,null) . "\n";
}

test_get_products_info();
# test_get_genres();
?>
