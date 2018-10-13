<?php
require_once("../config/database.php");

if (!(array_key_exists('user', $_SESSION))) {echo "User not logged"; die();}

$data = $_REQUEST;

if (array_key_exists('submitnewlogin', $data)) {
  if (!array_key_exists('newusername', $data) || !strlen($data['newusername'])) {echo "New username field not found"; die();}
  if (!array_key_exists('newmail', $data) || !strlen($data['newmail'])) {echo "New mail field not found"; die();}
  if (!preg_match("/^[a-zA-Z0-9]{5,10}$/", $data['newusername'])) {echo "New username field mal-formed"; die();}
  if (!preg_match("/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/", $data['newmail'])) {echo "New email field mal-formed"; die();}

  $foundUser = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username AND `id` != :userid");
  $foundUser->execute(array('username' => $data['username'], 'userid' => $_SESSION["user"]["id"]));
  $foundMail = $pdo->prepare("SELECT * FROM `users` WHERE `email` = :email AND `id` != :userid");
  $foundMail->execute(array('email' => $data['email'], 'userid' => $_SESSION["user"]["id"]));

  $foundUser = $foundUser->fetch();
  $foundMail = $foundMail->fetch();

  if ($foundUser && $foundMail) {echo "Username and Email already used"; die();}
  if ($foundUser) {echo "Username already used"; die();}
  if ($foundMail) {echo "Email already used"; die();}

  $update = $pdo->prepare("UPDATE `users` SET `username`=:username, `email`=:email WHERE `id`=:userid");
  $update->execute(array('username' => $data['username'], 'email' => $data['email'], 'userid' => $_SESSION["user"]["id"]));
  $_SESSION["user"]["email"] = $data['email'];
  $_SESSION["user"]["username"] = $data['username'];
}

if (array_key_exists('submitsetting', $data)) {
  $update = $pdo->prepare("UPDATE `users` SET `status`=:notify WHERE `id`=:userid");
  $update->execute(array('notify' => (array_key_exists('notify', $data) ? 1 : 0), 'userid' => $_SESSION["user"]["id"]));
  $_SESSION["user"]["status"] = (array_key_exists('notify', $data) ? 1 : 0);
}

if (array_key_exists('submitnewpass', $data)) {
  if (!array_key_exists('oldpass', $data) || !strlen($data['oldpass'])) {echo "Old password field not found"; die();}
  if (!array_key_exists('newpass', $data) || !strlen($data['newpass'])) {echo "New password field not found"; die();}
  if (!array_key_exists('confirmpass', $data) || !strlen($data['confirmpass'])) {echo "Confirm password field not found"; die();}

  if ($data['oldpass'] === $data['newpass']) { die();}

  if ($data['newpass'] !== $data['confirmpass']) {echo "New Passwords must match"; die();}

  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['oldpass'])) {echo "Old password field mal-formed"; die();}
  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['newpass'])) {echo "New password field mal-formed"; die();}
  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['confirmpass'])) {echo "Confirm password field mal-formed"; die();}
  
  $update = $pdo->prepare("UPDATE `users` set `pwd` = ':password' where `id` = ':userid'");
  $update->execute(array(':password' => hash('whirlpool', $data['confirmpass']), ':userid' => $_SESSION["user"]["id"]));
}

header("location: /");
