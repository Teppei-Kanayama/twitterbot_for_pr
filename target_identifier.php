<?php
$filepath = "./target/todai_rikei.csv";

$req = file_get_contents("http://tps.lefthandle.net/rest/?s=東大工&sort=recent");
#var_dump(json_decode($req));
$searched_accounts = json_decode($req);
foreach ($searched_accounts as $key => $searched_account){
  $content = $searched_account->id . ",";
  var_dump($content);
  file_put_contents($filepath, $content, $flags=FILE_APPEND);
  #echo("$searched_account->id\n");
}

/*
$file = new SplFileObject($filepath);
$file->setFlags(SplFileObject::READ_CSV);
foreach ($file as $line) {
  if(!is_null($line[0])){
    $records[] = $line;
  }
}
var_dump($records);
*/
?>
