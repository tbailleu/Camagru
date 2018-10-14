<?php
require_once("../config/database.php");

if (array_key_exists('user', $_SESSION)) {echo "User logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (count($data) != 3) {echo "Invalid number of arguments needed (3) but received (".count($data).")"; die();}
if (!array_key_exists('username', $data) || !strlen($data['username'])) {echo "Username field not found"; die();}
if (!array_key_exists('email', $data) || !strlen($data['email'])) {echo "Email field not found"; die();}
if (!array_key_exists('password', $data) || !strlen($data['password'])) {echo "Password field not found"; die();}
    
if (!preg_match("/^[a-zA-Z0-9]{5,10}$/", $data['username'])) {echo "Username field mal-formed"; die();}
if (!preg_match("/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/", $data['email'])) {echo "Email field mal-formed"; die();}
if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['password'])) {echo "Password field mal-formed"; die();}

$foundUser = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
$foundUser->execute(array('username' => $data['username']));
$foundMail = $pdo->prepare("SELECT * FROM `users` WHERE `email` = :email");
$foundMail->execute(array('email' => $data['email']));

$foundUser = $foundUser->fetch();
$foundMail = $foundMail->fetch();

if ($foundUser && $foundMail) {echo "Username and Email already used"; die();}
if ($foundUser) {echo "Username already used"; die();}
if ($foundMail) {echo "Email already used"; die();}

$token = hash("whirlpool", $data['username']) . hash("whirlpool", rand(1,10000));

$pdo->prepare("INSERT INTO `users` (`username`, `email`, `pwd`, `status`, `activationkey`) VALUES (:username, :email, :pwd, 1, :token)")
    ->execute(array('username' => $data['username'], 'email' => $data['email'], 'pwd' => hash("whirlpool", $data['password']), 'token' => $token));

mail( 
    $data['email'],
    "Confimation de compte", 
	"Merci pour votre inscription !\r\n Veuillez confimer votre inscription en cliquant sur".
    "\r\nhttp://".$HOSTNAME."/utils/activate.php?token=" . $token
);
echo "Ok";
