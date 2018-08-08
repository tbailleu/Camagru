<?php
	$GLOBALS['ok'] = true;
	require_once("database.php");

	
	try {
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec("DROP DATABASE IF EXISTS `camagru`");
		$pdo->exec("CREATE DATABASE IF NOT EXISTS `camagru`");
		$pdo->exec("USE camagru");
		$pdo->exec("CREATE TABLE `users` (
			`id` int(11) NOT NULL PRIMARY KEY UNIQUE KEY AUTO_INCREMENT,
			`username` varchar(30) NOT NULL UNIQUE KEY,
			`pwd` varchar(250) NOT NULL,
			`email` varchar(30) NOT NULL UNIQUE KEY,
			`activationkey` varchar(250) NOT NULL,
			`status` int(2) NOT NULL DEFAULT '-1')");

		$pdo->exec("CREATE TABLE `image` (
			`id` int(11) NOT NULL PRIMARY KEY UNIQUE KEY AUTO_INCREMENT,
			`path` varchar(250) NOT NULL,
			`user_id` int(11) NOT NULL)");

		$pdo->exec("CREATE TABLE `comment` (
			`id` int(11) NOT NULL PRIMARY KEY UNIQUE KEY AUTO_INCREMENT,
			`text` varchar(250) NOT NULL,
			`user_id` int(11) NOT NULL,
			`image_id` int(11) NOT NULL)");
	
	} catch (PDOException $e) {
		echo 'Échec lors de la connexion : ' . $e->getMessage();
		die();
	}