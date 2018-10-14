<?php
require_once("database.php");

$pdo->exec("DROP DATABASE IF EXISTS `camagru`");

$pdo->exec("CREATE DATABASE IF NOT EXISTS `camagru`");
$pdo->exec("USE camagru");
$pdo->exec("CREATE TABLE `users` (
	`id` int(11) NOT NULL PRIMARY KEY UNIQUE KEY AUTO_INCREMENT,
	`username` varchar(30) NOT NULL UNIQUE KEY,
	`pwd` varchar(128) NOT NULL,
	`email` varchar(30) NOT NULL UNIQUE KEY,
	`activationkey` varchar(384) NOT NULL,
	`status` int(2) NOT NULL DEFAULT '0')");

$pdo->exec("CREATE TABLE `image` (
	`id` int(11) NOT NULL PRIMARY KEY UNIQUE KEY AUTO_INCREMENT,
	`path` varchar(250) NOT NULL,
	`nblike` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`user_id` int(11) NOT NULL)");

$pdo->exec("CREATE TABLE `comment` (
	`id` int(11) NOT NULL PRIMARY KEY UNIQUE KEY AUTO_INCREMENT,
	`text` varchar(250) NOT NULL,
	`user_id` int(11) NOT NULL,
	`image_id` int(11) NOT NULL)");

$pdo->exec("INSERT INTO `image` (`id`, `path`, `nblike`, `user_id`) VALUES
								(1, 'utils/images/1.png', 29, 1),
								(2, 'utils/images/2.png', 52, 1),
								(3, 'utils/images/3.png', 57, 1),
								(4, 'utils/images/4.png', 54, 1),
								(5, 'utils/images/5.png', 46, 1),
								(6, 'utils/images/6.png', 15, 1),
								(7, 'utils/images/7.png', 71, 1),
								(8, 'utils/images/8.png', 52, 1),
								(9, 'utils/images/9.png', 64, 1),
								(10, 'utils/images/10.png', 37, 1),
								(11, 'utils/images/11.png', 71, 1),
								(12, 'utils/images/12.png', 34, 1),
								(13, 'utils/images/13.png', 10, 1),
								(14, 'utils/images/14.png', 82, 1),
								(15, 'utils/images/15.png', 46, 1),
								(16, 'utils/images/16.png', 37, 1);");

$pdo->exec("INSERT INTO `users` (
		`username`,
		`email`,
		`pwd`,
		`status`,
		`activationkey`
	) VALUES (
		'tbailleu',
		'poubelle50@hotmail.fr',
		'".hash('whirlpool', "Pass1234")."',
		1,
		'0'
	)");
