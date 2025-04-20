<?php
//for display error in browser
error_reporting(E_ALL);
ini_set("display_errors", 1);

$host = "localhost";
$username = "mohamed";
$password = "Mohamed@8112001";
$dbname = "ecotrail_db";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

?>