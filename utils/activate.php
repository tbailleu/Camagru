<?php
require_once("../config/database.php");

if (array_key_exists('user', $_SESSION)) {echo "User logged"; die();}

$token = $_REQUEST["token"];

if (!preg_match("/^[a-z0-9]{256}$/", $token)) {echo "Token mal-formed"; die();}

$foundUser = $pdo->prepare("SELECT * FROM `users` WHERE `activationkey` = :token");
$foundUser->execute(array('token' => $token));

$foundUser = $foundUser->fetch();

if (!$foundUser) {echo "Token invalid"; die();}

$update = $pdo->prepare("UPDATE `users` SET `activationkey` = 0 WHERE `id`=:userid");
$update->execute(array('userid' => intval($foundUser['id'])));

$_SESSION["user"] = $foundUser;
header("Location: /");
