<?php
include "connDB.php";


$sql_create_db = "CREATE DATABASE Web_Programming";
if ($pdo->exec($sql_create_db) !== false) {
  echo "База данных успешно создана<br>";
} else {
  echo "Ошибка при создании базы данных: " . $pdo->errorInfo() . "<br>";
}

$pdo->exec("USE Web_Programming");

$sql_file = file_get_contents('../SQL/students.sql');
if ($pdo->exec($sql_file) !== false) {
  echo "Таблица успешно создана из файла students.sql<br>";
}
