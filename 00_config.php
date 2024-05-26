<?php

// definition of the connection parameters for the database
$db_host     = 'localhost';     // host server where the db is running.
// «localhost» means: the same server address where the pages are stored

$db_name = '164933_4_1';   // name of the database (coincidentally matches username in the example)
$db_user = '164933_4_1';   // name of the db user (coincidentally matches database name in the example)
$db_pass = '4cnt0r1M8xjf';  // password of the db user

$db_charset  = 'utf8mb4';       // see https://www.hydroxi.de/utf8-vs-utf8mb4/

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset"; // see https://en.wikipedia.org/wiki/Data_source_name
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false
];

?>
