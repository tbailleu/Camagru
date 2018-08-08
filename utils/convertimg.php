<?php
	$sticker = imagecreatefrompng("stickers/1.png");
	

	$_POST['img'] = str_replace(' ', '+', $_POST['img']);
	$img = imagecreatefromstring(base64_decode(explode(',', $_POST['img'])[1]));
	
	imagecopyresized($img, $sticker, $_POST['x'], $_POST['y'], 0, 0, $_POST['sx'], $_POST['sy'], imagesx($sticker), imagesy($sticker));
	header('Content-Type: image/png');
    imagepng($img);
	imagedestroy($img);
//var_dump($_POST);

