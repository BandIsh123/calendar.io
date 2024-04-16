<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
} catch (PDOException $e) {

    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}
?>
