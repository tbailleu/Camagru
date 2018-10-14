<?php
require_once("../config/database.php");

if (!(array_key_exists('user', $_SESSION))) {echo "User not logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (count($data) != 1) {echo "Invalid number of arguments needed (1) but received (".count($data).")"; die();}
if (!array_key_exists('imageid', $data) || !strlen($data['imageid'])) {echo "image ID not found"; die();}

$img = $pdo->prepare("SELECT * FROM `image` WHERE `id`=:imageid AND `user_id`=:userid")
           ->execute(array('imageid' => intval($data['imageid']), 'userid' => $_SESSION["user"]["id"]));

if (!$img) {echo "Forbidden action"; die();}

$pdo->prepare("DELETE FROM `image` WHERE `id`=:imageid AND `user_id`=:userid")
    ->execute(array('imageid' => intval($data['imageid']), 'userid' => $_SESSION["user"]["id"]));

die();header("location: /");