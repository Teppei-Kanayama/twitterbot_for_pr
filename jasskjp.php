<?php
require_once("./twitteroauth/twitteroauth.php");
require_once("./utility.php");
ini_set( 'display_errors', 1 );

//アカウント情報の読み込み
list($consumer_key,$consumer_secret,$access_token,$access_token_secret) = read_account_info("./accounts/jasskjp.json");
// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$now_day = date("d");
$now_hour = date("H");
$now_minute = date("i");
$now_day_z = date("z");

$target = "@ROJE_edu";

auto_tweet($to, "./tweets/tweets_jasskjp.json", $now_hour, $now_minute);
#auto_follow($to, $target, $now_hour, $now_minute, 10, 7, "./log_files/followed_list_jasskjp.txt");
?>
