<?php
    $db_host = getenv('MYSQL_Host', true) ?: getenv('MYSQL_HOST');
    $db_name = getenv('MYSQL_DATABASE', true) ?: getenv('MYSQL_DATABASE');
    $db_port = getenv('MYSQL_PORT', true) ?: getenv('MYSQL_PORT');
    $db_pwd  = getenv('MYSQL_ROOT_PASSWORD', true) ?: getenv('MYSQL_ROOT_PASSWORD');

    #echo "db_host: {$db_host}<br>";


$con = mysqli_connect($db_host,"root",$db_pwd,$db_name,$db_port);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?> 