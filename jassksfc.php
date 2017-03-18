<?php
require_once("./twitteroauth/twitteroauth.php");
ini_set( 'display_errors', 1 );

$json_info = file_get_contents("./accounts/jassksfc.json");
$account_info = json_decode($json_info);
$consumer_key = $account_info->consumer_key;
$consumer_secret = $account_info->consumer_secret;
$access_token = $account_info->access_token;
$access_token_secret = $account_info->access_token_secret;
// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$req_main = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/mentions_timeline.json", "GET", array());
$result = json_decode($req_main);
echo $req_main;

$now_day = date("d");
$now_hour = date("H");
$now_minute = date("i");
$now_day_z = date("z");

$target = "@AIESECSFC";

//定期ポスト
$tweets_info = json_decode(file_get_contents("./tweets/tweets_jassksfc.json"));
foreach($tweets_info as $tmp => $tweet_info){
  if($now_hour == $tweet_info->hour && $now_minute == $tweet_info->minute){
    $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet_info->content));
  }
}

$freq = 10;
$remain = rand(1, $freq - 1);

echo "$now_minute\n";
echo "$freq\n";
echo "$remain\n";

if($now_minute % $freq == $remain && $now_hour >= 7){
  $req = $to->OAuthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array("screen_name"=>$target));
  $to_follow_accounts = json_decode($req)->ids;

  $fp = fopen("./log_files/followed_list_jassksfc.txt", "r");
  $followed_accounts = array();
  while(!feof($fp)){
    $buffer = fgets($fp);
    array_push($followed_accounts, $buffer);
  }
  fclose($fp);

  foreach ($to_follow_accounts as $key1 => $to_follow_ids) {
    $is_having_followed = False;
    echo "$to_follow_ids\n";
    foreach ($followed_accounts as $num => $followed_ids){
      if ($followed_ids == $to_follow_ids || $to_follow_ids >= 100000000000000){
        $is_having_followed = True;
        break;
      }
    }
    if ($is_having_followed == False){
      $req = $to->OAuthRequest("https://api.twitter.com/1.1/friendships/create.json","POST",array("user_id"=>$to_follow_ids));
      $fp = fopen("./log_files/followed_list_jassksfc.txt", "a");
      fputs($fp, "$to_follow_ids\n");
      fclose($fp);
      break;
    }
  }

}
?>
