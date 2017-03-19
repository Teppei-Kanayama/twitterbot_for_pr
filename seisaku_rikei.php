<?php
require_once("./twitteroauth/twitteroauth.php");
require_once("./utility.php");
ini_set( 'display_errors', 1 );

list($consumer_key,$consumer_secret,$access_token,$access_token_secret) = read_account_info("./accounts/seisaku_rikei.json");
// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$now_day = date("d");
$now_hour = date("H");
$now_minute = date("i");
$now_day_z = date("z");

auto_tweet($to, "./tweets/tweets_seisaku_rikei.json", $now_hour, $now_minute);
?>
