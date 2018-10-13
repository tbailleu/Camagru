<?php
	require_once("../config/database.php");

    if (session_status()==PHP_SESSION_NONE) session_start();

	if (!array_key_exists('user', $_SESSION)) {echo "User not logged"; die();}

	$data = json_decode($_REQUEST['json'], true);

	$sticker = imagecreatefrompng("stickers/".intval($data['sticker']).".png");
	
	$data['img'] = str_replace(' ', '+', $data['img']);
	$img = imagecreatefromstring(base64_decode(explode(',', $data['img'])[1]));
	
	imagecopyresized($img, $sticker, intval($data['x']), intval($data['y']), 0, 0, intval($data['sx']), intval($data['sy']), imagesx($sticker), imagesy($sticker));
	
	$next_id = intval($pdo->query("SELECT `id` FROM `image` ORDER BY `id` DESC")->fetch()['id'])+1;
	
	imagepng($img, "images/".$next_id.".png");

	$pdo->prepare("INSERT INTO `image` (`path`, `user_id`) VALUES (:path, :user_id)")
		->execute(array('path' => "utils/images/".$next_id.".png" , 'user_id' => $_SESSION['user']['id']));

	imagedestroy($img);
	imagedestroy($sticker);