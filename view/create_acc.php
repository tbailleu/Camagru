<?php
    if (!isset($_POST['login']) || !isset($_POST['email']) || !isset($_POST['pwd']) || !isset($_POST['confirm']) || !isset($_POST['submit']) || $_POST['submit'] != 'OK')
    {
        header("Location: create_acc.php?err=0");
        return ;
    }
    if (strlen($_POST['login']) < 5 || strlen($_POST['login']) > 10 || !preg_match("/[\w]{5,10}/", $_POST['login']))
    {
        header("Location: create_acc.php?err=1");
        return ;
    }