<?php

$host = "localhost";
$db = "Web_Programming";
$user = "root";
$pass = "root";

try {
  $pdo = new PDO("mysql: host=$host; dbname=$db", $user, $pass);
  "successful connection<br>";
} catch (\Throwable $e) {
  echo "Database connection error {$e->getMessage()}";
}
