<?php
	require_once("../config/database.php");

	if (!array_key_exists('user', $_SESSION)) {echo "User not logged"; die();}

	$data = json_decode($_REQUEST['json'], true);

	if (count($data) != 6) {echo "Invalid number of arguments needed (6) but received (".count($data).")"; die();}
	if (!array_key_exists('sid', $data) || !strlen($data['sid'])) {echo "Sticker ID not found"; die();}
	if (!array_key_exists('img', $data) || !strlen($data['img'])) {echo "Image Base64 data not found"; die();}
	if (!array_key_exists('x', $data) || !strlen($data['x'])) {echo "Sticker pos X not found"; die();}
	if (!array_key_exists('y', $data) || !strlen($data['y'])) {echo "Sticker pos Y not found"; die();}
	if (!array_key_exists('sx', $data) || !strlen($data['sx'])) {echo "Sticker size X not found"; die();}
	if (!array_key_exists('sy', $data) || !strlen($data['sy'])) {echo "Sticker size Y not found"; die();}

	if (intval($data['sid']) > 5 || intval($data['sid']) < 0) {echo "Sticker ID not in range 0 to 5"; die();};

	if (intval($data['sx']) <= 0 || intval($data['sy']) <= 0) {echo "Sticker must have positive and not null size"; die();}

	try {
		$sticker = imagecreatefrompng("stickers/".intval($data['sid']).".png");

		$data['img'] = str_replace(' ', '+', $data['img']);
		$img = imagecreatefromstring(base64_decode(explode(',', $data['img'])[1]));
		
		imagecopyresized($img, $sticker, intval($data['x']), intval($data['y']), 0, 0, intval($data['sx']), intval($data['sy']), imagesx($sticker), imagesy($sticker));
		
		$next_id = intval($pdo->query("SELECT `id` FROM `image` ORDER BY `id` DESC")->fetch()['id'])+1;
		
		imagepng($img, "images/".$next_id.".png");
	
		$pdo->prepare("INSERT INTO `image` (`path`, `user_id`) VALUES (:path, :user_id)")
			->execute(array('path' => "utils/images/".$next_id.".png" , 'user_id' => $_SESSION['user']['id']));
	
		imagedestroy($img);
		imagedestroy($sticker);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n"; die();
	}

echo "Ok";