<?php
    if (session_status()==PHP_SESSION_NONE) session_start();
    $_SESSION['user']['id'] = 1;
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
    // require "view/capture.php";
    require "view/galerie.php";
    ?>
    <?php require "view/footer.php";?>
</body>
</html>