<?php

	require_once('connect.php');

	session_start();
	if (!isset($_SESSION['user_id'])) {

		die('Ошибка: Пользователь не авторизован.');
	}

	if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
		$id = $_POST['Event'][0];
		$start = $_POST['Event'][1];
		$end = $_POST['Event'][2];
		$sql = "UPDATE events SET  start = '$start', end = '$end' WHERE id = $id ";
		$query = $bdd->prepare($sql);
		if ($query == false) {
			print_r($bdd->errorInfo());
			die ('Ошибка prepare');
		}
		$sth = $query->execute();
		if ($sth == false) {
			print_r($query->errorInfo());
			die ('Ошибка execute');
		} else {
			die('OK');
		}
	} else {

		die('Ошибка: Данные о событии не были переданы.');
	}
	
?>
