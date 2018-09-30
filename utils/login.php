<?php
require_once("../config/database.php");

session_start();

if (array_key_exists('user', $_SESSION)) {echo "User logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (count($data) != 2) {echo "Invalid number of arguments needed (2) but received (".count($data).")"; die();}
if (!array_key_exists('username', $data) || !strlen($data['username'])) {echo "Username field not found"; die();}

if (array_key_exists('reset', $data)) {
    
}

if (!array_key_exists('password', $data) || !strlen($data['password'])) {echo "Password field not found"; die();}

if (!preg_match("/^[a-zA-Z0-9]{5,10}$/", $data['username'])) {echo "Username field mal-formed"; die();}
if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['password'])) {echo "Password field mal-formed"; die();}

$foundUser = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
$foundUser->execute(array('username' => $data['username']));

if (!$foundUser->fetch()) {echo "User not found"; die();}

$user = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username AND `pwd` = :pwd");
$user->execute(array('username' => $data['username'], 'pwd' => hash('whirlpool', $data['password'])));

if (!($data = $user->fetch())) {echo "Invalid credentials"; die();}
$_SESSION['user'] = $data;

header("location: /");