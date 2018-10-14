<?php
if ($_SERVER["PHP_SELF"] != "/index.php") header("location: /");
if (array_key_exists('user', $_SESSION)) header("location: /");
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

/* Style the container for inputs */
.form {
    background-color: #f1f1f1;
    padding: 20px;
}

/* The message box is shown when the user clicks on the password field */
.error {
    display: none;
    background: #f1f1f1;
    position: relative;
    padding: 20px;
    margin-top: 10px;
}

.visible {
    display: block;
}

.error p {
    color: red;
    padding: .5em 2em;
    font-size: 1.1em;
}

.error > p:before {
    position: relative;
    left: -2em;
    content: "✖";
}

.error > p.valid {
    color: green;
}

.error > p.valid:before {
    content: "✔";
}

</style>
<div class="container">
    <form class="form">
        <label for="username">Username</label>
            <input type="text" data-error="user" name="username" required>
        <label for="email">Email</label>
            <input type="text" data-error="mail" name="email" required>
        <label for="password">Password</label>
            <input type="password" data-error="pass" name="password" required>
        <label for="confirm">Confirm Password</label>
            <input type="password" data-error="pass2" name="confirm" required>
        <input type="submit" value="Submit" name="submit">
    </form>
    <div class="error err-user">
        <p>Only alpha-numeric characters</p>
        <p>Minimum 5 characters</p>
        <p>Maximum 10 characters</p>
    </div>
    <div class="error err-mail">
        <p>Valide email</p>
    </div>
    <div class="error err-pass">
        <p>A lowercase letter</p>
        <p>A capital (uppercase) letter</p>
        <p>A number</p>
        <p>Minimum 8 characters</p>
        <p>Maximum 30 characters</p>
    </div>
    <div class="error err-pass2">
        <p>Password confirmed</p>
    </div>
</div>
<pre id="error"></pre>
<script>
    var inputs = [].slice.call(document.querySelectorAll(".form > input[type='text'], .form > input[type='password']"));

    inputs.forEach(function(elem, index){
        elem.onkeyup = elem.checkValidation = function() {
            var errorFields = [].slice.call(document.querySelectorAll(".error.err-"+this.dataset.error+" p"));
            errorFields.forEach(function(elem){elem.classList.remove("valid");});
            this.style.borderColor = "#4CAF50";
            switch (index) {
                case 0://username
                    if (/[a-zA-Z0-9]/.test(this.value)) errorFields[0].classList.add("valid");
                    if (this.value.length >= 5) errorFields[1].classList.add("valid");
                    if (this.value.length >= 5 && this.value.length <= 10) errorFields[2].classList.add("valid");
                    if (/^[a-zA-Z0-9]{5,10}$/.test(this.value)) return true;break;
                case 1://email
                    if (/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/.test(this.value)) errorFields[0].classList.add("valid");
                    if (/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/.test(this.value)) return true;break;
                case 2://password
                    if (/[a-z]/.test(this.value)) errorFields[0].classList.add("valid");
                    if (/[A-Z]/.test(this.value)) errorFields[1].classList.add("valid");
                    if (/[0-9]/.test(this.value)) errorFields[2].classList.add("valid");
                    if (this.value.length >= 8) errorFields[3].classList.add("valid");
                    if (this.value.length >= 8 && this.value.length <= 30) errorFields[4].classList.add("valid");
                    if (/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/.test(this.value)) return true;break;
                case 3://password confirm
                    if (this.value == inputs[2].value) errorFields[0].classList.add("valid");
                    if (this.value == inputs[2].value) return true;break;
                default:break;
            }
            this.style.borderColor = "#d00";
            return false;
        }
        elem.onfocus = function(){document.querySelector(".error.err-"+this.dataset.error).style.display = "block";}
        elem.onblur = function(){document.querySelector(".error.err-"+this.dataset.error).style.display = "none";}
    });

    document.querySelector(".form > input[type='submit']").onclick = function(e) {
        e.preventDefault();
        if (!inputs.map(function(elem){return elem.checkValidation();}).includes(false)){
            var xhr  = new XMLHttpRequest()
            xhr.open('POST', "utils/signup.php", true)
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                var response = xhr.responseText;
                if (xhr.readyState == 4 && xhr.status == "200") {
                    if (response == "Ok") location = location.origin;
                    document.querySelector("#error").innerHTML = response;
                } else {
                    //console.error(response);
                }
            }
            var tab = {};
            inputs.forEach(function(e, i){if (i!=3)return tab[e.name]=e.value;});
            xhr.send("json="+encodeURI(JSON.stringify(tab)));
        }
    }
</script>