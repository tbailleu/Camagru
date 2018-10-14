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
								(2, 'utils/images/2.png', 29, 1),
								(3, 'utils/images/3.png', 52, 1),
								(4, 'utils/images/4.png', 57, 1),
								(5, 'utils/images/5.png', 54, 1),
								(6, 'utils/images/6.png', 46, 1),
								(7, 'utils/images/7.png', 15, 1),
								(8, 'utils/images/8.png', 164, 1),
								(9, 'utils/images/9.png', 58, 1),
								(10, 'utils/images/10.png', 71, 1),
								(11, 'utils/images/11.png', 20, 1),
								(12, 'utils/images/12.png', 52, 1),
								(13, 'utils/images/13.png', 148, 1),
								(14, 'utils/images/14.png', 64, 1),
								(15, 'utils/images/15.png', 37, 1),
								(16, 'utils/images/16.png', 12, 1),
								(17, 'utils/images/17.png', 71, 1),
								(18, 'utils/images/18.png', 46, 1),
								(19, 'utils/images/19.png', 34, 1),
								(20, 'utils/images/20.png', 2, 1),
								(21, 'utils/images/21.png', 10, 1),
								(22, 'utils/images/22.png', 82, 1),
								(23, 'utils/images/23.png', 46, 1),
								(24, 'utils/images/24.png', 37, 1),
								(25, 'utils/images/25.png', 124, 1)");

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
