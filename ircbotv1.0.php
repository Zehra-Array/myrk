#!/usr/bin/php5
<?php
$info = array();
if (array_search('--help',$argv)) {
 exit("ircPHPBot\n\nType ircbot (if installed correctly) to start the bot.\n\nYou can also use the parameters: channel, name and owner.\nExample: ircbot channel <channel> name IRCBOT owner myrk\n");
}
set_time_limit(0);
function check($find,$msg) {
 global $text, $server, $info;
 if (strpos($text,$find)) {
  fwrite($server,"PRIVMSG ".$info['channel']." :".$msg."\n");
 }
}
$x = array('.','channel','name','owner');
foreach ($x as $v) {
 if (array_search($v,$argv)) {
  $p = array_search($v,$argv) + 1;
  $info["$v"] = $argv[$p];
 }
}
if (!isset($info['channel'])) {
 echo "Welcome! Please enter the channel:\n";
 $info['channel'] = fgets(STDIN);
 $info['channel'] = trim($info['channel']);
}
if (!isset($info['name'])) {
 echo "Nickname?\n";
 $info["name"] = fgets(STDIN);
 $info["name"] = trim($info["name"]);
}
if (!isset($info['owner'])) {
 echo "What may be your own nickname?\n";
 $info["owner"] = fgets(STDIN);
 $info["owner"] = trim($info["owner"]);
}
bcscale(20);
$server = fsockopen('irc.freenode.net',6667);
fwrite($server,"NICK ".$info["name"]."\n");
fwrite($server,"USER ".$info["name"]." localhost 68.5.244.72 :PHP IRCBOT\n");
fwrite($server,"JOIN ".$info['channel']."\n");
while (1 == 1) {
 if (!feof($server)) {
  $text = fgets($server);
  echo $text;
  if (strpos($text,"calc")) {
   $pos = strpos($text,"calc");
   $str = substr($text,($pos + 4));
   $str = explode(' ',$str);
   foreach ($str as $k => $v) {
    $str[$k] = trim($v);
   }
   if (is_numeric($str[1]) && is_numeric($str[3])) {
    if ($str[2] == 'x') {
     $str = bcmul($str[1],$str[3]);
    }
    elseif ($str[2] == '+') {
     $str = bcadd($str[1],$str[3]);
    }
    elseif ($str[2] == '/') {
     $str = bcdiv($str[1],$str[3]);
    }
    else {
     $str = '?';
    }
    echo $str;
    fwrite($server,"PRIVMSG ".$info['channel']." :$str\n");
   }
  }
  if (strpos($text,"attack:")) {
   $pos = strpos($text,"attack");
   $str = substr($text,($pos + 6));
   $str = explode(':',$str);
   $string = $str[1];
   $string = trim($string,"\n");
   for ($num = 0;$num < 1000;$num = $num + 1) {
    if (is_int(bcdiv($num,5))) {
     sleep(5);
    }
    fwrite($server,'PRIVMSG '.$string.' :SPAM!!!'."\n");
   }
  }
  if (strpos($text,"PING :")) {
   $pos = strpos($text,"PING");
   $str = substr($text,($pos + 4));
   $str = explode(':',$str);
   $string = $str[1];
   $string = trim($string,"\n");
   fwrite($server,"PONG :".$string."\n");
  }
  if (strpos($text,"die:")) {
   $pos = strpos($text,"die");
   $str = substr($text,($pos + 3));
   $str = explode(':',$str);
   $string = $str[1];
   $string = trim($string,"\n");
   fwrite($server,'PRIVMSG '.$string.' :DIE!!!'."\n");
  }
  if (strpos($text,"pi\n")) {
   fwrite($server,'PRIVMSG '.$info['channel']." :".pi(20)."\n");
  }
  if (strpos($text,"[Team]")) {
   $pos = strpos($text,"[Team]");
   $str = substr($text,($pos + 6));
   fwrite($server,'PRIVMSG '.$info["owner"].' :team said: '.$str);
  }
  elseif (!strpos($text,'team said:')) {
   check("hi bot","Hi there!");
   check('!help','Contact an administrator for help.');
   check('lol','FUNNY!!!');
   check('haha','LOL!');
   check(":hi",'Heya!');
   check(":yes",'WOW');
   check(":no",'Meanie!');
   check('blew myself up','DO NOT BLOW YOURSELVES UP!!!');
   check('JOIN :','Hi there!');
   check(':i like','You do?');
   check(" sw\n",'/flag give '.$info['owner'].' sw');
   check(" wg\n",'/flag give '.$info['owner'].' wg');
   check(" l\n",'/flag give '.$info['owner'].' l');
  }
  if (strpos($text,"!leave")) {
   fwrite($server,'PART :Quit: I LIKE PIE!!!');
  }
  if (strpos($text,"greekify")) {
   $pos = strpos($text,"greekify");
   $str = substr($text,$pos);
   $str = explode(":",$str);
   $web = curl_init();
   curl_setopt($web,CURLOPT_URL,"http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode($str[1])."&langpair=en|el");
   curl_setopt($web,CURLOPT_RETURNTRANSFER,TRUE);
   $web = curl_exec($web);
   $web = explode('"',$web);
   $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'A'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
   );
   $web = strtr($web[5],$table);
   fwrite($server,"PRIVMSG ".$info['channel']." :$web\n");
  }
 }
}
