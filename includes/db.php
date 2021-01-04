<?php

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_password'] = "";
$db['db_database'] = "cms";

foreach($db as $key => $value){
  define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// $connection = mysqli_connect('localhost', 'root', '', 'cms');

// if($connection){
//   echo "We are connected";
// }


?>