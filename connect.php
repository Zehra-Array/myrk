#!/usr/bin/php5
<?php
set_time_limit(0);
echo "Please enter the address: (without port)\n";
$addr = fgets(STDIN);
$addr = trim($addr);
echo "Now enter the port:\n";
$port = fgets(STDIN);
$port = (int)$port;
$server = fsockopen($addr,$port) or exit("srry");
echo fgets($server);
while (1 == 1) {
 echo fread($server,1000);
 while (!feof(STDIN)) {
  $text = fgets(STDIN);
  if ($text != "\n") {
   if (strpos($text,"64")) {
    $pos = strpos($text,"64");
    $text = substr($text,$pos + 2);
    $text = base64_encode($text);
   }
   $text = str_replace("\n","",$text);
   $text = str_replace("\r","",$text);
   fwrite($server,$text."\n\r");
  }
 }
}
?>
