<?php
require_once("./twitteroauth/twitteroauth.php");
//header("Content-Type: text/html; charset=UTF-8");
ini_set( 'display_errors', 1 );

$json_info = file_get_contents("./accounts/seisaku_rikei.json");
$account_info = json_decode($json_info);
$consumer_key = $account_info->consumer_key;
$consumer_secret = $account_info->consumer_secret;
$access_token = $account_info->access_token;
$access_token_secret = $account_info->access_token_secret;

// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$req_main = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/mentions_timeline.json", "GET", array());
$result = json_decode($req_main);

$now_day = date("d");
$now_hour = date("H");
$now_minute = date("i");
$now_day_z = date("z");

//定期ポスト
$text1 = "【2017春新歓のお知らせ】瀧本ゼミ政策分析パートは今春も新規ゼミ生を募集いたします。理系の方、新しく別の団体で精力的に活動してみたい方、所属大学、学年、専攻問わずどなたでも大歓迎です。説明会の詳細は別途ご案内いたしますので、本アカウントを随時チェックしてください。";

$text2 = "「社会的にはまだあまり知られていないような医学の知見で、社会全体に浸透すれば大きなインパクトがあること、というのはたくさんある」：医学部生だからこそ見える瀧本ゼミの魅力 - 瀧本ゼミ政策分析パート 新歓特設ブログ
http://seisaku2015.hatenablog.com/entry/2016/10/19/215714";

$text3 = "瀧本ゼミとは何か、これまで何をやってきたのか（AED、消火器、いじめなどのプロジェクト紹介）、普段どんなゼミをやっているのか、そして新歓説明会情報を掲載しています。http://seisaku.strikingly.com/   特にプロジェクトは詳細に紹介しています。";

$text4 = "参加資格は「大学生、大学院生であること」選考もありません。
理系の方の専門性を活かすこともできます。
高学年の方も研究に活きる論理的思考を磨くことができます。
少しでも関心がある方は、ぜひ説明会にいらしてください。
詳細はこちら→http://seisaku.strikingly.com/";

$text5 = "【4/11初回説明会情報】
「日本に500万人！？​世界で日本に特異的な依存症の原因とは？」＠東大駒場
4/11(火) 19-21時
集合: 正門前（18:50)
詳細はhttp://seisaku.strikingly.com/#_8 でご確認を
 pic.twitter.com/tXqeVJGe9A
";

$text6 = "「実践の中で必要な知識がどんどん蓄えられるというのも面白かったですし、知見がないなら作らなければいけないという所も面白かった」瀧本ゼミの魅力は？ 知的好奇心をくすぐる挑戦 - 瀧本ゼミ政策分析パート 新歓特設ブログ http://buff.ly/2eac527";

$text7 = "「最初は自信がなくても、自分の隠れた強みや、それを活かした戦い方に気づいて、実践することができる、そういう場が瀧本ゼミ」本当に大事なのはオリジナリティなのか？ゼミ5期生渡邊さんインタビュー - 瀧本ゼミ政策分析パート 新歓特設ブログ http://buff.ly/2dWdH3W";

$text8 = "新天地を探している皆さん、専門・進路・大学・学年を超えた仲間と、既存の団体での経験やインプットしてきた知識を活かして具体的なアクションを起こして世の中を変えてみませんか？
詳細はこちら→http://seisaku.strikingly.com/";

$text9 = "「減らせ突然死」年間7万人以上発生している心臓突然死を減らすために、瀧本ゼミ政策パートが推進し続けているあるプロジェクトがあります。 プロジェクトは様々な人々、組織の協力を得て、着実に歩みを進めています。http://buff.ly/2eiJVT1";

$text10 = "「日本の家屋を救う」⽊造密集住宅が主流の⽇本において根強い問題となっている火災。瀧本ゼミ政策パートでは、被害を大きく減らせる「家庭における消火器設置」を進めるために、その有効性を12万件の実際のデータに基づいて実証しました。http://buff.ly/2drG2fq";

if($now_hour == "12" && $now_minute == "00"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text1));
}

if($now_hour == "12" && $now_minute == "30"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text2));
}

if($now_hour == "13" && $now_minute == "00"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text3));
}

if($now_hour == "18" && $now_minute == "00"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text4));
}

if($now_hour == "18" && $now_minute == "30"){
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$text5));
}

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
?>
