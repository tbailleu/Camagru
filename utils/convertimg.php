<?php
	require_once("../config/database.php");

	session_start();

	if (!array_key_exists('user', $_SESSION)) {echo "User not logged"; die();}

	$sticker = imagecreatefrompng("stickers/".intval($_POST['sticker']).".png");
	
	$_POST['img'] = str_replace(' ', '+', $_POST['img']);
	$img = imagecreatefromstring(base64_decode(explode(',', $_POST['img'])[1]));
	
	imagecopyresized($img, $sticker, intval($_POST['x']), intval($_POST['y']), 0, 0, intval($_POST['sx']), intval($_POST['sy']), imagesx($sticker), imagesy($sticker));
	
	$next_id = intval($pdo->query("SELECT `id` FROM `image` ORDER BY `id` DESC")->fetch()['id'])+1;
	
	imagepng($img, "images/".$next_id.".png");

	$pdo->prepare("INSERT INTO `image` (`path`, `user_id`) VALUES (:path, :user_id)")
		->execute(array('path' => "utils/images/".$next_id.".png" , 'user_id' => $_SESSION['user']['id']));

	imagedestroy($img);
	imagedestroy($sticker);