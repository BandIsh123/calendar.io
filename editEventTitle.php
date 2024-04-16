<?php
	require_once('connect.php');


	session_start();
	if (!isset($_SESSION['user_id'])) {	
		header("Location: index.php");
		exit();
	}

	$user_id = $_SESSION['user_id'];

	if (isset($_POST['delete']) && isset($_POST['id'])) {

		$id = $_POST['id'];
		$sql = "DELETE FROM events WHERE id = :id AND user_id = :user_id";
		$query = $bdd->prepare($sql);
		$query->execute(array('id' => $id, 'user_id' => $user_id));

		header('Location: index.php');
		exit();
	} elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id'])) {

		$id = $_POST['id'];
		$title = $_POST['title'];
		$color = $_POST['color'];
		$sql = "UPDATE events SET title = :title, color = :color WHERE id = :id AND user_id = :user_id";
		$query = $bdd->prepare($sql);
		$query->execute(array('title' => $title, 'color' => $color, 'id' => $id, 'user_id' => $user_id));

		header('Location: index.php');
		exit();
	}
?>
