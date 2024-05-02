<?php
include "PHP_scripts/connDB.php";
include "utils.php";

$get_id = isset($_GET['id']) ? $_GET['id'] : null;

// Запрос в БД на получение всех данных 
$sql = $pdo->prepare("SELECT * FROM users");
$sql->execute();
// используем метод fetchAll который возвращает массив объекта
$result = $sql->fetchAll(PDO::FETCH_OBJ);


//Обновление данных $_SERVER['REQUEST_METHOD'] === "POST"
if (isset($_POST['edit-submit'])) {

  $SecondName = formatName($_POST['second_name']);
  $FirstName = formatName($_POST['first_name']);
  $isikukood = $_POST['isikukood'];
  $grade = $_POST['grade'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $err = [];

  if (empty($SecondName)) {
    $err['second_name'] = 'Заполните поле с фамилией';
    $err['general'] = 'Все поля должны быть заполнены!';
  }
  if (empty($FirstName)) {
    $err['first_name'] = 'Заполните поле с именем';
    $err['general'] = 'Все поля должны быть заполнены!';
  }
  if (empty($isikukood)) {
    $err['isikukood'] = 'Заполните поле с личным кодом';
    $err['general'] = 'Все поля должны быть заполнены!';
  }
  if (empty($grade)) {
    $err['grade'] = 'Заполните поле на каком курсе вы находитесь';
    $err['general'] = 'Все поля должны быть заполнены!';
  }
  if (empty($email)) {
    $err['email'] = 'Заполните поле с email';
    $err['general'] = 'Все поля должны быть заполнены!';
  }

  if (!empty($err)) {
    $err['general'] = 'Все поля должны быть заполнены!';
  } else {


    // Валидация isikukood
    if (!checkIsikukood($isikukood)) {
      $err['isikukood'] = 'Введен некоректный isikukood';
    }

    // Валидация email 
    if (!checkEmail($email)) {
      $err['email'] = 'Введен некорекный email';
    }

    if (!empty($err)) {
      // $err['general'] = 'Все поля должны быть заполнены!';
    } else {
      $sql = ("UPDATE users set SecondName=?, FirstName=?, isikukood=?, grade=?, email=?, message=? WHERE id=?");
      $query = $pdo->prepare($sql);
      $query->execute([$SecondName, $FirstName, $isikukood, $grade, $email, $message, $get_id]);
      if ($query) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
    }
  }
}

// Удаление 
if (isset($_POST['delete_submit'])) {
  $sql = ('DELETE FROM users WHERE id=?');
  $query = $pdo->prepare($sql);
  $query->execute([$get_id]);
  if ($query) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!-- Font awesome -->
  <script src="https://kit.fontawesome.com/ed38b77c42.js" crossorigin="anonymous"></script>
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
              <th>ID</th>
              <th>Second Name</th>
              <th>First name</th>
              <th>isikukood</th>
              <th>grade</th>
              <th>e-mail</th>
              <th>message</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($result as $row) { ?>
              <tr>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->SecondName ?></td>
                <td><?php echo $row->FirstName ?></td>
                <td><?php echo $row->isikukood ?></td>
                <td><?php echo $row->grade ?></td>
                <td><?php echo $row->email ?></td>
                <td><?php echo $row->message ?></td>
                <td><a href="?id=<?php echo $row->id; ?>" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row->id; ?>"><i class="fa fa-edit"></i></a>
                  <a href="" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <!-- Modal Edit-->
              <div class="modal fade" id="edit<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Редактировать запись № <?php echo $row->id; ?>
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="?id=<?= $row->id ?>" method="post">
                        <div class="form-group mb-3">
                          <input type="text" class="form-control" name="second_name" value="<?= $row->SecondName ?>" placeholder="Фамилия">
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" class="form-control" name="first_name" value="<?= $row->FirstName ?>" placeholder="Имя">
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" class="form-control" name="isikukood" value="<?= $row->isikukood ?>" placeholder="Персональный код">
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" class="form-control" name="grade" value="<?= $row->grade ?>" placeholder="Курс">
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" class="form-control" name="email" value="<?= $row->email ?>" placeholder="email">
                        </div>
                        <div class="form-group mb-3">
                          <input type="text" class="form-control" name="message" value="<?= $row->message ?>" placeholder="Сообщение">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="edit-submit" class="btn btn-primary">Обновить</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal Edit -->
              <!-- Modal Delete-->
              <div class="modal fade" id="delete<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Удалить запись № <?php echo $row->id; ?>
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      </button>
                    </div>
                    <form action="?id=<?= $row->id ?>" method="post">
                      <div class="modal-footer">
                        <button type="submit" name="delete_submit" class="btn btn-danger">Удалить</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Modal Delete -->
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>