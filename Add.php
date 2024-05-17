<?php
session_start();

// Подключаемся к БД
include "PHP_scripts/connDB.php";

//Добавляем файл с функциями 
include "utils.php";

// if ($_SERVER['REQUEST_METHOD'] === "POST") {
//   $SecondName = formatName($_POST['second_name']);
//   $FirstName = formatName($_POST['first_name']);
//   $isikukood = $_POST['isikukood'];
//   $grade = $_POST['grade'];
//   $email = $_POST['email'];
//   $message = $_POST['message'];

//   $err = [];

//   $fields = [
//     'second_name' => $SecondName,
//     'first_name' => $FirstName,
//     'isikukood' => $isikukood,
//     'grade' => $grade,
//     'email' => $email,
//   ];

//   foreach ($fields as $key => $value) {
//     if (empty($value)) {
//       $err[$key] = "Заполните поле с {$key}";
//       $err['general'] = 'Все поля должны быть заполнены!';
//     }
//   }

//   // Валидация isikukood
//   if (!checkIsikukood($isikukood)) {
//     $err['isikukood'] = 'Введен некорректный isikukood';
//   }

//   // Валидация email 
//   if (!checkEmail($email)) {
//     $err['email'] = 'Введен некорректный email';
//   }

//   // Проверка на наличие ошибок
//   if (empty($err)) {
//     $sql = "INSERT INTO users (SecondName, FirstName, isikukood, grade, email, message) VALUES (?,?,?,?,?,?)";
//     $query = $pdo->prepare($sql);
//     $query->execute([$SecondName, $FirstName, $isikukood, $grade, $email, $message]);
//     $full_name = $SecondName . ' ' . $FirstName;
//     $_SESSION['success_message'] = "$full_name успешно добавлен в базу данных!";
//     header("Location: " . $_SERVER['HTTP_REFERER']);
//     exit();
//   }
// }

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === "POST") {
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

    // Если нет ошибок в валидации, добавляем данные в базу данных
    if (!empty($err)) {
      // $err['general'] = 'Все поля должны быть заполнены!';
    } else {
      $sql = ("INSERT INTO users (SecondName, FirstName, isikukood, grade, email, message) values (?,?,?,?,?,?)");
      $query = $pdo->prepare($sql);
      $query->execute([$SecondName, $FirstName, $isikukood, $grade, $email, $message]);
      $full_name = $SecondName . ' ' . $FirstName;
      // Сохраняем сообщение об успешном добавлении в сессию
      $_SESSION['success_message'] = "$full_name успешно добавлен в базу данных!";
      header("Location: " . $_SERVER['HTTP_REFERER']);
      exit();
    }
  }
}


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://css.gg/css" rel="stylesheet" />
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
            <a class="nav-link active" aria-current="page" href="Add.php">Добавить</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="view.php">Посмотреть</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="delete.php">Удалить</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h1>Добавление записи в таблицу</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="form-group">
        <small>Second name</small>
        <input type="text" class="form-control" name="second_name" value="<?php echo isset($_POST['second_name']) ? $_POST['second_name'] : ''; ?>" placeholder="Обязательное поле">
        <small class="text-danger"><?php echo isset($err['second_name']) ? $err['second_name'] : ''; ?></small>
      </div>
      <div class="form-group">
        <small>First name</small>
        <input type="text" class="form-control" name="first_name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>" placeholder="Обязательное поле">
        <small class="text-danger"><?php echo isset($err['first_name']) ? $err['first_name'] : ''; ?></small>
      </div>
      <div class="form-group">
        <small>Isikukood</small>
        <input type="text" class="form-control" name="isikukood" value="<?php echo isset($_POST['isikukood']) ? $_POST['isikukood'] : ''; ?>" placeholder="Обязательное поле">
        <small class="text-danger"><?php echo isset($err['isikukood']) ? $err['isikukood'] : ''; ?></small>
      </div>
      <div class="form-group">
        <small>Grade</small>
        <input type="number" class="form-control" name="grade" value="<?php echo isset($_POST['grade']) ? $_POST['grade'] : ''; ?>" placeholder="Обязательное поле">
        <small class="text-danger"><?php echo isset($err['grade']) ? $err['grade'] : ''; ?></small>
      </div>
      <div class="form-group">
        <small>Email</small>
        <input type="text" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Обязательное поле">
        <small class="text-danger"><?php echo isset($err['email']) ? $err['email'] : ''; ?></small>
      </div>
      <div class="form-group">
        <small>Message</small>
        <input type="text" class="form-control" name="message" placeholder="Не обязательное поле">
      </div>
      <div class="modal-footer  justify-content-center pt-2">
        <button type="submit" class="btn btn-primary mx-2">Save</button>
        <button type="reset" class="btn btn-light">Отмена</button>
      </div>
    </form>
    <div class="text-danger"><?php echo isset($err['general']) ? $err['general'] : ''; ?></div>
    <div class="text-success"><?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?></div>
  </div>


  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
// Очистить сообщение об успехе после его вывода
unset($_SESSION['success_message']);
?>