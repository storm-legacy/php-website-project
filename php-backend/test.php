<?php

$num = (int)$_GET['string'];
$num++;

$string = strval($num);
$size = strlen($string);

for($i = 8; $i > $size; $i--) {
  $string = "0".$string;
}

echo $string;