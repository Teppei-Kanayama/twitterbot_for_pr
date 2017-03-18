<?php
require_once("./twitteroauth/twitteroauth.php");
require_once("./test_required.php");
ini_set( 'display_errors', 1 );

foo("aaaaa");

$json_info = file_get_contents("./accounts/test.json");
$account_info = json_decode($json_info);
$consumer_key = $account_info->consumer_key;
$consumer_secret = $account_info->consumer_secret;
$access_token = $account_info->access_token;
$access_token_secret = $account_info->access_token_secret;

// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$req_main = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/mentions_timeline.json", "GET", array());
$result = json_decode($req_main);

//$now_day = date("d");
//$now_hour = date("H");
$now_minute = date("i");
//$now_day_z = date("z");
var_dump("100" > 50);
var_dump($now_minute % 5);

#$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>"テスト"));
#$req = $to->OAuthRequest("https://api.twitter.com/1.1/friendships/create.json","POST",array("screen_name"=>"@teppeikanayama"));

$req = $to->OAuthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array("screen_name"=>"@katariba"));
$to_follow_accounts = json_decode($req)->ids;

$fp = fopen("./log_files/followed_list_jasskjp.txt", "r");
$followed_accounts = array();
while(!feof($fp)){
  $buffer = fgets($fp);
  array_push($followed_accounts, $buffer);
}
fclose($fp);

foreach ($to_follow_accounts as $key1 => $to_follow_ids) {
  $is_having_followed = False;
  echo "$to_follow_ids\n";
  foreach ($followed_accounts as $num => $followd_ids){
    if ($followd_ids == $to_follow_ids){
      $is_having_followed = True;
      break;
    }
  }
  if ($is_having_followed == False){
    #$req = $to->OAuthRequest("https://api.twitter.com/1.1/friendships/create.json","POST",array("user_id"=>$to_follow_ids, "follow"=>False));
    $fp = fopen("./log_files/followed_list_jasskjp.txt", "a");
    fputs($fp, "$to_follow_ids\n");
    fclose($fp);
    break;
  }
}
#var_dump($followed_accounts)

#var_dump($req_array->ids[100]);
?>
