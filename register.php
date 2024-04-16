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
    $full_name = $_POST["full_name"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = $bdd->prepare("SELECT * FROM users WHERE username = :username");
    $query->execute(array('username' => $username));
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        echo "Пользователь с таким именем уже существует.";
    } else {

        $insert_query = $bdd->prepare("INSERT INTO users (username, password, full_name) VALUES (:username, :password, :full_name)");
        $insert_query->execute(array('username' => $username, 'password' => $hashed_password, 'full_name' => $full_name));

        $_SESSION['user_id'] = $bdd->lastInsertId();
        $_SESSION['username'] = $username;

        header("Location: calendar.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задачи - Регистрация</title>
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
        <h1 class="text-center task-header mt-5 mb-4">Задачи - Регистрация</h1>
        
        <!-- Форма регистрации -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card task-item">
                    <div class="card-body">
                        <h5 class="card-title task-title"><span class="task-icon">&#128101;</span> Регистрация</h5>
                        <p class="card-text task-description">Пожалуйста, заполните форму для регистрации нового аккаунта.</p>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username">Имя пользователя:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="full_name">Полное имя:</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ссылка на страницу авторизации -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 text-center">
                <p>Уже есть аккаунт? <a href="index.php">Войдите</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>
