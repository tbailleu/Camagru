<?php
    //require("../config/database.php");
    $servername = "localhost";
    $username = "root";
    $password = "salut123";
    $db_name = "camagru";
    $tb_user = "users";
    $tb_img = "img";
    $tb_com = "com";
    $column_img = "(ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY, path VARCHAR(250), user_id INT)";
    $column_user = "(ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY, login VARCHAR(30), pwd VARCHAR(250), email VARCHAR(30), `key` VARCHAR(250), activ INT(1))";
    $column_com = "(ID INT( 11 ) AUTO_INCREMENT PRIMARY KEY, text VARCHAR(250), user_id INT, img_id INT)";
    try
    {
        $host = new PDO("mysql:host=$servername", $username, $password);
    }
    catch(PDOException $e)
    {
        die();
        return ;
    }
    $rq = "DROP DATABASE " . $db_name;
    $host->prepare($rq)->execute();
    $rq = "CREATE DATABASE " . $db_name;
    $host->prepare($rq)->execute();
    $bd = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $rq = "CREATE TABLE $tb_user $column_user";
    $bd->prepare($rq)->execute();
    $rq = "CREATE TABLE $tb_img $column_img";
    $bd->prepare($rq)->execute();
    $rq = "CREATE TABLE $tb_com $column_com";
    $bd->prepare($rq)->execute();
