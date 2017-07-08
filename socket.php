#!/usr/bin/php5
<?php 
set_time_limit(0);
$sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
socket_bind($sock,'localhost','4000');
socket_listen($sock);
$client = array();
$pid = array();
parent:
$num = count($client) + 1;
$client[$num] = socket_accept($sock);
$file = fopen('chatindex.txt','w+');
fwrite($file,$num);
fclose($file);
$pid[$num] = pcntl_fork();
if ($pid) {
 goto parent;
}
$fwrite = fopen("client$num.txt",'w+');
while (1 == 1) {
 $index = file_get_contents('chatindex.txt');
 foreach (range(1,$index) as $n) {
  if (file_get_contents("client$n.txt") != $send[$n]) {
   $send[$n] = file_get_contents("client$n.txt");
   fwrite($client[$num],"Client #$n says: ".$send[$n]."\n");
  }
 }
 $text = fread($client[$num],1000);
 if (strlen($text) > 1) {
  fwrite($fwrite,$text);
 }
}
socket_close($sock);
?>
