<?php
require_once("../config/database.php");

if (!(array_key_exists('user', $_SESSION))) {$_SESSION["error"] = "User not logged"; header("location: /?account");}

$data = $_REQUEST;

if (array_key_exists('submitnewlogin', $data)) {
  if (!array_key_exists('newusername', $data) || !strlen($data['newusername'])) {$_SESSION["error"] = "New username field not found"; header("location: /?account");}
  if (!array_key_exists('newmail', $data) || !strlen($data['newmail'])) {$_SESSION["error"] = "New mail field not found"; header("location: /?account");}
  if (!preg_match("/^[a-zA-Z0-9]{5,10}$/", $data['newusername'])) {$_SESSION["error"] = "New username field mal-formed"; header("location: /?account");}
  if (!preg_match("/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/", $data['newmail'])) {$_SESSION["error"] = "New email field mal-formed"; header("location: /?account");}

  $foundUser = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username AND `id` != :userid");
  $foundUser->execute(array('username' => $data['newusername'], 'userid' => $_SESSION["user"]["id"]));
  $foundMail = $pdo->prepare("SELECT * FROM `users` WHERE `email` = :email AND `id` != :userid");
  $foundMail->execute(array('email' => $data['newmail'], 'userid' => $_SESSION["user"]["id"]));

  $foundUser = $foundUser->fetch();
  $foundMail = $foundMail->fetch();

  if ($foundUser && $foundMail) {$_SESSION["error"] = "Username and Email already used"; header("location: /?account");}
  if ($foundUser) {$_SESSION["error"] = "Username already used"; header("location: /?account");}
  if ($foundMail) {$_SESSION["error"] = "Email already used"; header("location: /?account");}

  $update = $pdo->prepare("UPDATE `users` SET `username`=:username, `email`=:email WHERE `id`=:userid");
  $update->execute(array('username' => $data['newusername'], 'email' => $data['newmail'], 'userid' => $_SESSION["user"]["id"]));
  $_SESSION["user"]["email"] = $data['newmail'];
  $_SESSION["user"]["username"] = $data['newusername'];
}

if (array_key_exists('submitsetting', $data)) {
  $update = $pdo->prepare("UPDATE `users` SET `status`=:notify WHERE `id`=:userid");
  $update->execute(array('notify' => (array_key_exists('notify', $data) ? 1 : 0), 'userid' => $_SESSION["user"]["id"]));
  $_SESSION["user"]["status"] = (array_key_exists('notify', $data) ? 1 : 0);
}

if (array_key_exists('submitnewpass', $data)) {
  if (!array_key_exists('oldpass', $data) || !strlen($data['oldpass'])) {$_SESSION["error"] = "Old password field not found"; header("location: /?account");}
  if (!array_key_exists('newpass', $data) || !strlen($data['newpass'])) {$_SESSION["error"] = "New password field not found"; header("location: /?account");}
  if (!array_key_exists('confirmpass', $data) || !strlen($data['confirmpass'])) {$_SESSION["error"] = "Confirm password field not found"; header("location: /?account");}

  if ($data['oldpass'] === $data['newpass']) { header("location: /?account"); }

  if ($data['newpass'] !== $data['confirmpass']) {$_SESSION["error"] = "New Passwords must match"; header("location: /?account");}

  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['oldpass'])) {$_SESSION["error"] = "Old password field mal-formed"; header("location: /?account");}
  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['newpass'])) {$_SESSION["error"] = "New password field mal-formed"; header("location: /?account");}
  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['confirmpass'])) {$_SESSION["error"] = "Confirm password field mal-formed"; header("location: /?account");}
  
  $update = $pdo->prepare("UPDATE `users` set `pwd`=:pass where `id`=:userid AND `pwd`=:oldpass");
  if (!($update->execute(array('pass' => hash('whirlpool', $data['confirmpass']), 'userid' => $_SESSION["user"]["id"], 'oldpass' => hash('whirlpool', $data['oldpass'])))))
  {$_SESSION["error"] = "Old password is incorrect"; header("location: /?account");}
}

$_SESSION["error"] = "Ok";
header("location: /?account");
