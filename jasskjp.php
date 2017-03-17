<?php
require_once("./twitteroauth/twitteroauth.php");
ini_set( 'display_errors', 1 );

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
echo $req_main;

$now_day = date("d");
$now_hour = date("H");
$now_minute = date("i");
$now_day_z = date("z");

$target = "@katariba";

//定期ポスト
$text1 = "【前編】
【インタビュー】今回はJaSSKの前身である瀧本ゼミOB吉田さんのインタビュー前編です。「きっかけは身近なところにあった」と語る吉田さんは、どのようにしてAED普及に興味を持ち、活動を始めていったのでしょうか。https://goo.gl/CdXM7q";
$text2 = "【後編】
【インタビュー】JaSSKの前身である瀧本ゼミOB吉田さんのインタビュー後編です。「諦めずに営業して回った事が、チャンスに繋がった」と吉田さん。始めは上手く行かなかった活動も、とある人との出会いがきっかけで好転したそうです。https://goo.gl/1gqAwd";
$text3 = "JaSSKのOB大月さんのインタビューです。「きちんと分析を行い、動けば、結果が出るという実感を持つことができました。」と語る大月さん。消火器の更新・普及活動を進めていた彼は、いかにしてぶつかった壁を乗り越えたのか？記事はこちらから！https://goo.gl/IACvb2";
$text4 = "【前編】
JaSSKの前身である瀧本ゼミ生による、鈴木寛東大教授への対談前編です。「実は、政府は禁じていないのに、自治体の窓口や現場の長や担当者が政府のせいにしているケースが案外多い。」記事はこちらから！https://goo.gl/X9LDSj";
$text5 = "【後編】
JaSSKの前身の瀧本ゼミ生による、鈴木寛東大教授への対談後編です。「何かを動かす事はボタンのスイッチを押していく事だと思っているのですが、どのボタンをどういう風にどんな順番で押すのか理解している人は多くないです。」https://goo.gl/TsZuTk";
if($now_hour == "13" && $now_minute == "30"){
echo $now_hour;
echo $now_minute;
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text1));
echo $req;
}

if($now_hour == "14" && $now_minute == "03"){
//echo $now_hour;
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text2));
//echo $req;
}

if($now_hour == "17" && $now_minute == "30"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text3));
}

if($now_hour == "22" && $now_minute == "15"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text4));
}

if($now_hour == "22" && $now_minute == "45"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text5));
}


$freq = 10;
$remain = rand(1, $freq - 1);

echo "$freq\n";
echo "$remain\n"; ###

if($now_minute % $freq == $remain && $now_hour >= 7){
  $req = $to->OAuthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array("screen_name"=>$target));
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
      if ($followd_ids == $to_follow_ids || $to_follow_ids >= 100000000000000){
        $is_having_followed = True;
        break;
      }
    }
    if ($is_having_followed == False){
      $req = $to->OAuthRequest("https://api.twitter.com/1.1/friendships/create.json","POST",array("user_id"=>$to_follow_ids, "follow"=>False));
      $fp = fopen("./log_files/followed_list_jasskjp.txt", "a");
      fputs($fp, "$to_follow_ids\n");
      fclose($fp);
      break;
    }
  }

}

/*
if($now_hour == "19" && $now_minute == "00"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text6));
}

if($now_hour == "22" && $now_minute == "00"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text7));
}

if($now_hour == "22" && $now_minute == "20"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text8));
}

if($now_hour == "22" && $now_minute == "40"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text9));
}

if($now_hour == "23" && $now_minute == "00"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text10));
}
*/
?>
