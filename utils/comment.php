<?php
require_once("database.php");

if (!(array_key_exists('user', $_SESSION))) {echo "User not logged"; die();}

$data = json_decode($_REQUEST["json"], true);

if (count($data) != 2) {echo "Invalid number of arguments needed (2) but received (".count($data).")"; die();}
if (!array_key_exists('imageid', $data) || !strlen($data['imageid'])) {echo "image ID not found"; die();}
if (!array_key_exists('message', $data) || !strlen($data['message']) || !strlen(trim($data['message']))) {echo "message field not found"; die();}

$data['message'] = trim($data['message']);

if (!preg_match("/^[a-zA-Z0-9 ]{1,250}$/", $data['message'])) {echo "Message field mal-formed"; die();}

$req = $pdo->prepare("INSERT INTO `comment` (`text`, `user_id`, `image_id`) VALUES (:msg, :userid, :imageid)");
$req->execute(array(
    'msg' => $data['message'],
    'userid' => $_SESSION['user']['id'],
    'imageid' => $data['imageid']
));

echo $data['message'];