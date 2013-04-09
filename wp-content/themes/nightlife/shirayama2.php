<?php
$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&restrict=countryJP&lr=lang_ja&"
    . "q=" . urlencode( "白山翔太" );

// sendRequest
// note how referer is set manually
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, "http://54.249.250.63/wordpress/");
curl_setopt($ch, CURLOPT_URL, $url);

// now, process the JSON string
$json = json_decode( curl_exec($ch) );

#var_dump( $json );
#foreach( $json->responseData->results as $result ){
#	echo $result->content;
#}
#echo "\n\n";



$start = rand( 0, max( 0, intval($json->responseData->cursor->resultCount) - 4 ));

$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&restrict=countryJP&lr=lang_ja&start=" . $start . "&"
    . "q=" . urlencode( "白山翔太" );


curl_setopt($ch, CURLOPT_URL, $url);
// now, process the JSON string
$json = json_decode( curl_exec($ch) );

$tmp_string = "";
foreach( $json->responseData->results as $result ){
        $tmp_string .= $result->content;
}
echo $tmp_string;



$url = "http://jlp.yahooapis.jp/KeyphraseService/V1/extract?appid=dj0zaiZpPXg2NThaaVV0TjN0YyZkPVlXazlNVmRXTkhGTk5XTW1jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9ZGE-&output=json&sentence="
 . urlencode( $tmp_string );

curl_setopt($ch, CURLOPT_URL, $url);
// now, process the JSON string

#var_dump( curl_exec($ch) );
$json = json_decode( curl_exec($ch) );

#var_dump( $json );

$hoge = (array)$json;

$keyword = array_keys( $hoge );
echo "\n\n";
echo $keyword[0];

curl_close($ch);
?>
