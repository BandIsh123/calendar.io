<?php

require_once('connect.php');

session_start();
if (isset($_SESSION['user_id'])) {

    header("Location: calendar.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = $bdd->prepare("SELECT * FROM users WHERE username = :username");
    $query->execute(array('username' => $username));
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo "Session set: User ID - " . $_SESSION['user_id'] . ", Username - " . $_SESSION['username'];

        header("Location: calendar.php");
        exit();
    } else {
        echo "Неверное имя пользователя или пароль.";
    }
} else {

}
?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задачи - Авторизация</title>
    <!-- Подключение Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Подключение стилей -->
    <style>
        body {
            background-color: #eef5f9; /* изменение цвета фона */
        }
        .container {
            margin-top: 100px;
        }
        .task-icon {
            font-size: 24px;
            margin-right: 10px;
            color: #007bff; /* изменение цвета иконок */
        }
        .task-header {
            color: #007bff; /* изменение цвета заголовка */
            margin-bottom: 20px;
        }
        .task-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ced4da; /* изменение цвета границы */
            border-radius: 5px;
            background-color: #fff; /* изменение цвета фона элемента */
        }
        .task-item:hover {
            background-color: #f8f9fa; /* изменение цвета фона при наведении */
        }
        .task-title {
            font-weight: bold;
        }
        .task-description {
            color: #6c757d; /* изменение цвета описания задачи */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center task-header mb-4">Задачи - Авторизация</h1>
        
        <!-- Форма авторизации -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card task-item">
                    <div class="card-body">
                        <h5 class="card-title task-title"><span class="task-icon">&#128190;</span> Авторизация</h5>
                        <p class="card-text task-description">Пожалуйста, войдите в систему, чтобы продолжить.</p>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username">Имя пользователя:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ссылка на страницу регистрации -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 text-center">
                <p>Еще нет аккаунта? <a href="register.php">Пройдите регистрацию</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>


