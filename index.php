<?php
    require_once("config/database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="reset.css">
    <title>Camagru</title>
</head>
<body>
    <?php require "view/header.php";?>
    <?php 
    if (array_key_exists('capture', $_REQUEST)) require "view/capture.php";
    elseif (array_key_exists('account', $_REQUEST)) require "view/account.php";
    elseif (array_key_exists('login', $_REQUEST)) require "view/signin.php";
    elseif (array_key_exists('signup', $_REQUEST)) require "view/signup.php";
    else require "view/galerie.php";
    ?>
    <?php require "view/footer.php";?>
</body>
</html>