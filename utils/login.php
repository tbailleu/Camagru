<?php
require_once("../config/database.php");

if (array_key_exists('user', $_SESSION)) {echo "User logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (!array_key_exists('username', $data) || !strlen($data['username'])) {echo "Username field not found"; die();}
if (!preg_match("/^[a-zA-Z0-9]{5,10}$/", $data['username'])) {echo "Username field mal-formed"; die();}

$foundUser = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username");
$foundUser->execute(array('username' => $data['username']));

$foundUser = $foundUser->fetch();
if (!$foundUser) {echo "User not found"; die();}

if (array_key_exists('reset', $data)) {
    $newpass = "";
    $taba = "0123456789";
    $tabb = "abcdefghijklmnopqrstuvwxyz";
    $tabc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i=0; $i < 7; $i++) {
        $newpass .= $taba[mt_rand(0, 9)] . $tabb[mt_rand(0, 25)] . $tabc[mt_rand(0, 25)];
    }
    $update = $pdo->prepare("UPDATE `users` SET `pwd` = :passwd WHERE `id`=:userid");
    $update->execute(array('passwd' => hash('whirlpool', $newpass), 'userid' => intval($foundUser['id'])));
    mail(
		$foundUser["email"],
		"Reinitialisation du mot de passe", 
        "Bonjour ".$foundUser["username"]."\r\nVotre mot de passe a ete reinitialise, penser a le changer dans vos paramettre.\r\n".
        "nouveau mot de passe : ".$newpass
    );
    echo "Ok";
    die();
}
else if (count($data) != 2) {echo "Invalid number of arguments needed (2) but received (".count($data).")"; die();}

if (!array_key_exists('password', $data) || !strlen($data['password'])) {echo "Password field not found"; die();}
if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/", $data['password'])) {echo "Password field mal-formed"; die();}

$user = $pdo->prepare("SELECT * FROM `users` WHERE `username` = :username AND `pwd` = :pwd");
$user->execute(array('username' => $data['username'], 'pwd' => hash('whirlpool', $data['password'])));

$user = $user->fetch();
if (!$user) {echo "Invalid credentials"; die();}

if ($user["activationkey"] != "0") {echo "Activate your account first"; die();}

$_SESSION['user'] = $user;

echo "Ok";