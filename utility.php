<?php

function read_account_info($path_to_account_info){
  $account_info = json_decode(file_get_contents($path_to_account_info));
  $consumer_key = $account_info->consumer_key;
  $consumer_secret = $account_info->consumer_secret;
  $access_token = $account_info->access_token;
  $access_token_secret = $account_info->access_token_secret;
  return array($consumer_key,$consumer_secret,$access_token,$access_token_secret);
}

function auto_tweet($to, $path_to_tweet_contents, $now_hour, $now_minute){
  $tweets_info = json_decode(file_get_contents($path_to_tweet_contents));
  foreach($tweets_info as $tmp => $tweet_info){
    if($now_hour == $tweet_info->hour && $now_minute == $tweet_info->minute){
      $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet_info->content));
    }
  }
  return 0;
}

function auto_follow($to, $target, $now_hour, $now_minute, $freq, $thresh, $path_to_followed_list){
  $remain = rand(1, $freq - 1);

  if($now_minute % $freq == $remain && $now_hour >= $thresh){
    $req = $to->OAuthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array("screen_name"=>$target));
    $to_follow_accounts = json_decode($req)->ids;

    $fp = fopen($path_to_followed_list, "r");
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
        $fp = fopen($path_to_followed_list, "a");
        fputs($fp, "$to_follow_ids\n");
        fclose($fp);
        break;
      }
    }

  }
  return 0;
}

 ?>
