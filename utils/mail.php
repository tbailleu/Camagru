<?php

function accountchanged($dest)
{
	mail(
		$dest,
		"mise a jour des preferences d'utilisation",
		"vos preferences ont ete modifie ". date("D M j G:i:s"), 
		array('From'=>'camagru@supersite.com')
	);
}

function sendcomment($dest, $comment)
{
	mail(
		$dest,
		"Votre Image a ete commente !", 
		"Votre image a ete commente le " . date("D M j G:i:s") . "\r\ncommentaire : ". $comment,
		array('From'=>'camagru@supersite.com')
	);
}

function confirmaccount($dest, $token)
{
	mail(
		$dest,
		"confimation de compte", 
		"Merci pour votre inscription !\r\n Veuillez confimer votre inscription en cliquant sur http://site/validation?token=" . $token,
		array('From'=>'camagru@supersite.com')
	);
}

function sendlike($dest, $nblike)
{
	mail(
		$dest,
		"votre image a ete like !", 
		"Votre image a recu un like : http://lien\r\nnombre de likes : " . $nblike,
		array('From'=>'camagru@supersite.com')
	);
}

function resetpassword($dest, $lien)
{
	mail(
		$dest,
		"reinitialisation du mot de passe", 
		"veuillez reinitialiser votre mot de passe en cliquant sur ce lien : " . $lien,
		array('From'=>'camagru@supersite.com')
	);
}