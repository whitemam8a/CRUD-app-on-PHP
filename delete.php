<?php
session_start();
// Подключаемся к БД
include "PHP_scripts/connDB.php";

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  try {
    $sql = ("DELETE FROM users");
    $query = $pdo->prepare($sql);
    $query->execute();
    $_SESSION['success_del'] = "Все даннные успешно удаленны";
    // header("Location: " . $_SERVER['HTTP_REFERER']);
  } catch (\Throwable $th) {
    echo "Ошибка удаления записей из таблицы students: " . $e->getMessage();
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
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="main.php">Итоговое задание SQL & PHP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="Add.php">Добавить</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="view.php">Посмотреть</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="delete.php">Удалить</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h2>Удаление всех записей</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <p>Вы уверены, что хотите удалить все записи из таблицы?</p>
      <input type="submit" name="delete_all" value="Удалить все записи">
    </form>
    <p><?php echo isset($_SESSION['success_del']) ? $_SESSION['success_del'] : "" ?></p>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php unset($_SESSION['success_del']); ?>