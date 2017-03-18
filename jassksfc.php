<?php
require_once("./twitteroauth/twitteroauth.php");
require_once("./utility.php");
ini_set( 'display_errors', 1 );
/*
$json_info = file_get_contents("./accounts/jassksfc.json");
$account_info = json_decode($json_info);
$consumer_key = $account_info->consumer_key;
$consumer_secret = $account_info->consumer_secret;
$access_token = $account_info->access_token;
$access_token_secret = $account_info->access_token_secret;
*/
//アカウント情報取得
list($consumer_key,$consumer_secret,$access_token,$access_token_secret) = read_account_info("./accounts/jassksfc.json");
// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$now_day = date("d");
$now_hour = date("H");
$now_minute = date("i");
$now_day_z = date("z");

$target = "@AIESECSFC";

auto_tweet($to, "./tweets/tweets_jassksfc.json", $now_hour, $now_minute);
auto_follow($to, $target, $now_hour, $now_minute, 10, 7, "./log_files/followed_list_jassksfc.txt");
?>
