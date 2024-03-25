<?php
session_start(); // Начать сессию

// Подключение к базе данных
include 'PHP_scripts/connDB.php';

// Установка начальных значений переменных для сообщений об ошибках
$errors = array('surname' => '', 'name' => '', 'isikukood' => '', 'grade' => '', 'email' => '');

// Проверка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Получение данных из формы
  $SecondName = $_POST['surname'];
  $FirstName = $_POST['name'];
  $isikukood = $_POST['personal_code'];
  $grade = $_POST['grade'];
  $email = $_POST['email'];

  // Проверка заполненности основных полей формы
  if (empty($SecondName) || empty($FirstName) || empty($isikukood) || empty($grade) || empty($email)) {
    // Если хотя бы одно из обязательных полей не заполнено, выводим сообщение об ошибке
    $errors['general'] = 'Все поля формы должны быть заполнены';
  } else {
    // Валидация личного кода (пример валидации, может быть доработана в соответствии с требованиями)
    if (!preg_match('/^[0-9]{11}$/', $isikukood)) {
      $errors['isikukood'] = 'Некорректный личный код';
    }

    // Валидация email (пример валидации, может быть доработана в соответствии с требованиями)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Некорректный адрес электронной почты';
    }

    // Если нет ошибок в валидации, добавляем данные в базу данных
    if (array_filter($errors) == false) {
      $sql = "INSERT INTO users (SecondName, FirstName, isikukood, grade, email) VALUES (?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$SecondName, $FirstName, $isikukood, $grade, $email]);

      $full_name = $SecondName . ' ' . $FirstName;
      // Сохраняем сообщение об успешном добавлении в сессию
      $_SESSION['success_message'] = "$full_name успешно добавлен в базу данных!";
      header("Location: " . $_SERVER['HTTP_REFERER']);

      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Student</title>
</head>

<body>
  <h2>Add Student</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
      <label for="surname">Фамилия студента:</label><br>
      <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname ?? ''); ?>">
      <div><?php echo empty($errors['second_name']) ? "" : $errors['second_name']; ?></div>
    </div>
    <div>
      <label for="name">Имя студента:</label><br>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>">
      <div><?php echo empty($errors['first_name']) ? "" : $errors['first_name']; ?></div>
    </div>
    <div>
      <label for="personal_code">Личный код:</label><br>
      <input type="text" id="personal_code" name="personal_code" value="<?php echo htmlspecialchars($personal_code ?? ''); ?>">
      <div><?php echo empty($errors['isikukood']) ? "" : $errors['isikukood']; ?></div>
    </div>
    <div>
      <label for="grade">Grade:</label><br>
      <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($grade ?? ''); ?>">
      <div><?php echo empty($errors['grade']) ? "" : $errors['grade'] ?></div>
    </div>
    <div>
      <label for="email">E-mail:</label><br>
      <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
      <div><?php echo $errors['email']; ?></div>
    </div>
    <div>
      <button type="submit">Запись</button>
      <button type="reset">Отмена</button>
    </div>
    <div><?php echo empty($errors['general']) ? "" : $errors['general']; ?></div>
    <div><?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?></div>
  </form>
</body>

</html>

<?php
// Очистить сообщение об успехе после его вывода
unset($_SESSION['success_message']);
?>