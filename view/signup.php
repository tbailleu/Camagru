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
    cursor:pointer;
}

/* Style the container for inputs */
.container {
    background-color: #f1f1f1;
    padding: 20px;
}

/* The message box is shown when the user clicks on the password field */
#message, #message_usr, #message_confirm, #message_email {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
}

#message p, #message_usr p, #message_confirm p, #message_email p{
    padding: 10px 35px;
    font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
    color: green;
}

.valid:before {
    position: relative;
    left: -35px;
    content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
    color: red;
}

.invalid:before {
    position: relative;
    left: -35px;
    content: "✖";
}
</style>
<div class="container">
    <label for="usrname">Username</label>
    <input type="text" id="usrname" name="usrname">
    <label for="email">Email</label>
    <input type="text" id="email" name="email" required>
    <label for="psw">Password</label>
    <input type="password" id="psw" name="psw">
    <label for="confirm">Confirm Password</label>
    <input type="password" id="confirm" name="confirm">
   <input type="submit" value="Submit" id="submit">
</div>
<div id="message">
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
  <p id="maximum" class="invalid">Maximum <b>30 characters</b></p>
</div>
<div id="message_usr">
  <p id="letter_usr" class="invalid">Only <b>alpha-numeric</b> characters</p>
  <p id="min" class="invalid">Minimum <b>5 characters</b></p>
  <p id="max" class="invalid">Maximum <b>10 characters</b></p>
</div>
<div id="message_confirm">
  <p id="confirmation" class="invalid">Password <b>confirmed</b></p>
</div>
<div id="message_email">
  <p id="valide_email" class="invalid">Valide <b>email</b></p>
</div>

<script src="view/signup.js">
</script>