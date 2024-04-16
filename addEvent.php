<?php

// Подключение к базе данных
require_once('connect.php');

// Проверка наличия параметров в POST-запросе
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color']) && isset($_POST['user_id'])){
	
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];
	$user_id = $_POST['user_id']; // Получаем user_id из формы

	// Формирование SQL-запроса с указанием всех параметров
	$sql = "INSERT INTO events(title, start, end, color, user_id) VALUES ('$title', '$start', '$end', '$color', '$user_id')";
	
	// Вывод сформированного SQL-запроса для проверки
	echo $sql;
	
	// Подготовка и выполнение запроса
	$query = $bdd->prepare($sql);
	if ($query == false) {
		print_r($bdd->errorInfo());
		die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
		print_r($query->errorInfo());
		die ('Erreur execute');
	}

}

// Перенаправление на предыдущую страницу
header('Location: '.$_SERVER['HTTP_REFERER']);

?>