<?php
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

input[data-type=reset] {
    background-color: #AF3333;
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
    <form class="form">
        <label for="newusername">User name</label>
        <input type="newusername" name="newusername" placeholder="<?=$_SESSION["user"]["username"];?>" value="<?=$_SESSION["user"]["username"];?>" required>
        <label for="newmail">Email address</label>
        <input type="newmail" name="newmail" placeholder="<?=$_SESSION["user"]["email"];?>" value="<?=$_SESSION["user"]["email"];?>" required>
        <input type="submit" value="Save" data-type="newmail">
    </form>
    <form class="form">
        <label>Email notifications</label>
        <input type="checkbox" name="notify" <?=$_SESSION["user"]["status"]==1?"checked":"";?>>
        <input type="submit" value="Save" data-type="setting">
    </form>
    <form class="form">
        <label for="oldpass">Old password</label>
        <input type="oldpass" name="oldpass" required>
        <label for="newpass">New password</label>
        <input type="newpass" name="newpass" required>
        <label for="confirmpass">Confirm new password</label>
        <input type="confirmpass" name="confirmpass" required>
        <input type="submit" value="Save" data-type="newpass">
    </form>
</div>