<?php

$infoDB = [
  "host" => "mysql",
  "user" => "root",
  "passwd" => "root",
  "dbName" => "cloneTube",
];


$connection = mysqli_connect($infoDB['host'], $infoDB['user'], $infoDB['passwd'], $infoDB['dbName']);

if(!$connection) {
  die("FFS =>".mysqli_connect_error());
}
