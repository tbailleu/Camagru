<?php
require_once("../config/database.php");

if (!(array_key_exists('user', $_SESSION))) {echo "User not logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (count($data) != 1) {echo "Invalid number of arguments needed (1) but received (".count($data).")"; die();}
if (!array_key_exists('imageid', $data) || !strlen($data['imageid'])) {echo "image ID not found"; die();}

$req = $pdo->prepare("SELECT `nblike` FROM `image` WHERE `id`=:imageid");
if (!($req->execute(array('imageid' => intval($data['imageid']))))){
    echo "Invalid imageid"; die();
};
$nblike = intval($req->fetch()["nblike"]);

if ($nblike < 2147483645)
    $nblike++;
else { echo "Well done, you won this game !!!"; die(); }

$update = $pdo->prepare("UPDATE `image` SET `nblike`=:nblike WHERE `id`=:imageid");
$update->execute(array('nblike' => $nblike, 'imageid' => intval($data['imageid'])));

echo $nblike;