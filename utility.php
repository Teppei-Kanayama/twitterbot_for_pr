<?php

function read_account_info($path_to_account_info){
  $account_info = json_decode(file_get_contents($path_to_account_info));
  $consumer_key = $account_info->consumer_key;
  $consumer_secret = $account_info->consumer_secret;
  $access_token = $account_info->access_token;
  $access_token_secret = $account_info->access_token_secret;
  return array($consumer_key,$consumer_secret,$access_token,$access_token_secret);
}

function auto_tweet($to, $path_to_tweet_contents, $now_hour, $now_minute, $now_date=False){
  $tweets_info = json_decode(file_get_contents($path_to_tweet_contents));

  #毎日ツイートする場合（旧来の方法）
  if(now_date == False){
    foreach($tweets_info as $tmp => $tweet_info){
      if($now_hour == $tweet_info->hour && $now_minute == $tweet_info->minute){
        $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet_info->content));
      }
    }
    return 0;
  }

  if(array_key_exists("is_once", $tweets_info)){
    foreach($tweets_info as $tmp => $tweet_info){
      var_dump($now_date);
      if($now_hour == $tweet_info->hour && $now_minute == $tweet_info->minute && $now_date == $tweet_info->number){
        $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet_info->content));
      }
    }
  }

  #2日周期でツイート内容を切り替える場合
  foreach($tweets_info as $tmp => $tweet_info){
    if(array_key_exists("is_once", $tweet_info)){
      var_dump($now_date);
      if($now_hour == $tweet_info->hour && $now_minute == $tweet_info->minute && $now_date == $tweet_info->number){
        $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet_info->content));
      }
    }else{
      if($now_hour == $tweet_info->hour && $now_minute == $tweet_info->minute && $now_date % 2 == $tweet_info->number){
        $req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$tweet_info->content));
      }
    }
  }
  return 0;
}

function auto_follow($to, $target, $now_hour, $now_minute, $freq, $thresh, $path_to_followed_list){
  $remain = rand(1, $freq - 1);
  echo $now_minute . "\n";
  echo $freq . "\n";
  echo $remain . "\n";

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
        $tmp = fputs($fp, "$to_follow_ids\n");
        var_dump($tmp);
        fclose($fp);
        break;
      }
    }

  }
  return 0;
}

function auto_follow2($to, $path_to_target_list, $now_hour, $now_minute, $freq, $thresh, $path_to_followed_list){
  $remain = rand(1, $freq - 1);
  echo $now_minute . "\n";
  echo $freq . "\n";
  echo $remain . "\n";

  if($now_minute % $freq == $remain && $now_hour >= $thresh){
    #$req = $to->OAuthRequest("https://api.twitter.com/1.1/followers/ids.json","GET",array("screen_name"=>$target));
    #$to_follow_accounts = json_decode($req)->ids;

    $filepath = $path_to_target_list;
    $file = new SplFileObject($filepath);
    $file->setFlags(SplFileObject::READ_CSV);
    foreach ($file as $line) {
      if(!is_null($line[0])){
        #var_dump($line);
        $to_follow_accounts[] = $line;
      }
    }

    $fp = fopen($path_to_followed_list, "r");
    $followed_accounts = array();
    while(!feof($fp)){
      $buffer = fgets($fp);
      array_push($followed_accounts, $buffer);
    }
    fclose($fp);

    $count = 0;
    #var_dump($to_follow_accounts[0]);
    foreach ($to_follow_accounts[0] as $key => $to_follow_ids) {
      $is_having_followed = False;
      #var_dump($followed_accounts);
      foreach ($followed_accounts as $num => $followed_ids){
        #var_dump($followed_accounts);
        $followed_ids = trim($followed_ids);
        $isequal = ($followed_ids == $to_follow_ids);
        #echo "$followed_ids == $to_follow_ids";
        #var_dump($isequal);
        #var_dump($followed_ids);
        #var_dump($to_follow_ids);
        #echo "$to_follow_ids"
        if ($followed_ids == $to_follow_ids || $to_follow_ids >= 100000000000000){
          $is_having_followed = True;
          break;
        }
      }
      if ($is_having_followed == False){
        $req = $to->OAuthRequest("https://api.twitter.com/1.1/friendships/create.json","POST",array("user_id"=>$to_follow_ids));
        var_dump($to_follow_ids);
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
