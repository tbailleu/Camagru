<?php
require_once("../config/database.php");

if (!(array_key_exists('user', $_SESSION))) {echo "User not logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (count($data) != 1) {echo "Invalid number of arguments needed (1) but received (".count($data).")"; die();}
if (!array_key_exists('imageid', $data) || !strlen($data['imageid'])) {echo "image ID not found"; die();}

$req = $pdo->prepare("SELECT * FROM `image` WHERE `id`=:imageid");
if (!($req->execute(array('imageid' => intval($data['imageid']))))){
    echo "Invalid imageid"; die();
};
$req = $req->fetch();
$nblike = intval($req["nblike"]);

if ($nblike < 2147483645)
    $nblike++;
else { echo "Well done, you won this game !!!"; die(); }

$update = $pdo->prepare("UPDATE `image` SET `nblike`=:nblike WHERE `id`=:imageid");
$update->execute(array('nblike' => $nblike, 'imageid' => intval($data['imageid'])));

$user = $pdo->prepare("SELECT `email`, `username` FROM `users` WHERE `id` = :id");
$user->execute(array('id' => $req["user_id"]));
$user = $user->fetch();

mail(
    $user["email"],
    "Votre image a ete like !", 
    "Bonjour ".$user["username"]."\r\nVotre image a recu un like : http://".$HOSTNAME."/".$req["path"]."\r\nnombre de likes : " . $nblike
);

echo $nblike;