<?php
include "PHP_scripts/connDB.php";

// функция передаются шесть строковых переменных (значения полей базы данных) и
// возвращают строку, содержащую фрагмент таблицы в формате HTML
function formatTableRow($SecondName, $FirstName, $isikukood, $grade, $email, $message)
{
  $row = "<tr>";
  $row .= "<td>$SecondName</td>";
  $row .= "<td>$FirstName</td>";
  $row .= "<td>$isikukood</td>";
  $row .= "<td>$grade</td>";
  $row .= "<td>$email</td>";
  $row .= "<td>$message</td>";
  $row .= "</tr>";

  return $row;
}

// Запрос в БД на получение всех данных 
$sql = $pdo->prepare("SELECT * FROM users");
$sql->execute();
// используем метод fetchAll который возвращает массив объекта
$result = $sql->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Итоговое задание SQL & PHP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="Add.php">Добавить</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="view.php">Посмотреть</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="delete.php">Удалить</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-12 mt-2">
        <table class="table table-striped table-hover table-bordered border-secondary mt-2">
          <thead class="table-dark">
            <tr>
              <th>Second Name</th>
              <th>First name</th>
              <th>isikukood</th>
              <th>grade</th>
              <th>e-mail</th>
              <th>message</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($result as $row) {
              echo formatTableRow($row->SecondName, $row->FirstName, $row->isikukood, $row->grade, $row->email, $row->message);
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>