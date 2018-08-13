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
</style>
<div class="container">
    <form class="form">
        <label for="username">Username</label>
            <input type="text" data-error="user" name="username" required>
        <label for="password">Password</label>
            <input type="password" data-error="pass" name="password" required>
        <input type="submit" value="Submit" name="submit">
    </form>
</div>
<script>
    var inputs = [].slice.call(document.querySelectorAll(".form > input[type='text'], .form > input[type='password']"));

    inputs.forEach(function(elem, index){
        elem.onkeyup = elem.checkValidation = function() {
            this.style.borderColor = "#4CAF50";
            switch (index) {
                case 0://username
                    if (/^[a-zA-Z0-9]{5,10}$/.test(this.value)) return true;break;
                case 1://password
                    if (/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/.test(this.value)) return true;break;
                default:break;
            }
            this.style.borderColor = "#d00";
            return false;
        }
    });

    document.querySelector(".form > input[type='submit']").onclick = function(e) {
        e.preventDefault();
        if (!inputs.map(function(elem){return elem.checkValidation();}).includes(false)){
            var xhr  = new XMLHttpRequest()
            xhr.open('POST', "utils/login.php", true)
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                var response = JSON.parse(xhr.responseText);
                if (xhr.readyState == 4 && xhr.status == "200") {
                    console.table(response);
                } else {
                    console.error(response);
                }
            }
            var tab = {};
            inputs.forEach(function(e){return tab[e.name]=e.value;});
            xhr.send("json="+encodeURI(JSON.stringify(tab)));
        }
    }
</script>
