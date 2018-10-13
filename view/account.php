<?php
if ($_SERVER["PHP_SELF"] != "/index.php") header("location: /");
require_once("config/database.php");
if (!array_key_exists('user', $_SESSION)) header("location: /");
?>
<style>
/* Style all input fields */
input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
}

/* Style the submit button */
input[type=submit] {
    background-color: #4CAF50;
    color: white;
    font-size: 1em;
    cursor: pointer;
}

input[name=submitsetting] {
    background-color: #dd721b;
}

input[name=submitnewpass] {
    background-color: #fd4646;
}

/* Style the container for inputs */
.form:nth-child(2n+1) {
    background-color: #e0e0e0;
    padding: 20px;
}
.form:nth-child(2n) {
    padding: 20px;
    background-color: #eeeeee;
}
</style>
<div class="container">
    <form class="form" action="utils/settings.php" method="post">
        <label for="newusername">User name</label>
        <input type="text" name="newusername" placeholder="<?=$_SESSION["user"]["username"];?>" value="<?=$_SESSION["user"]["username"];?>" required>
        <label for="newmail">Email address</label>
        <input type="email" name="newmail" placeholder="<?=$_SESSION["user"]["email"];?>" value="<?=$_SESSION["user"]["email"];?>" required>
        <input type="submit" value="Save" name="submitnewlogin">
    </form>
    <form class="form" action="utils/settings.php" method="post">
        <label for="notify">Settings</label>
        <input type="checkbox" name="notify" <?php
            if ($_SESSION["user"]["status"]===1) echo "checked";
        ?>>
        <input type="submit" value="Save" name="submitsetting">
    </form>
    <form class="form" action="utils/settings.php" method="post">
        <label for="oldpass">Old password</label>
        <input type="password" name="oldpass" required>
        <label for="newpass">New password</label>
        <input type="password" name="newpass" required>
        <label for="confirmpass">Confirm new password</label>
        <input type="password" name="confirmpass" required>
        <input type="submit" value="Save" name="submitnewpass">
    </form>
</div>