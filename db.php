<?php
////////////////////
// DB connection
$host = "host_here";
$dbName = "db_name_here";
$dbInfo = "mysql:host={$host};dbname={$dbName}";
$dbUser = "user_here";
$dbPassword = "password_here";

$db = "";
try {
    // try to create a db connection with a PDO (php data object)
    $db = new PDO($dbInfo, $dbUser, $dbPassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    die("<h1>Connection failed</h1><p>{$ex}</p>");
}
////////////////////
