
/*---------------------------- FIELDS -------------------------*/

var usr = document.getElementById("usrname"),
    pwd = document.getElementById("psw"),
    letter = document.getElementById("letter"),
    capital = document.getElementById("capital"),
    number = document.getElementById("number"),
    length = document.getElementById("length"),
    maximum = document.getElementById("maximum"),
    letter_usr = document.getElementById("letter_usr"),
    min = document.getElementById("min"),
    max = document.getElementById("max"),
    confirm = document.getElementById("confirm"),
    confirmation = document.getElementById("confirmation"),
    valide_email = document.getElementById("valide_email")
    email = document.getElementById("email"),
    submit = document.getElementById("submit"),
    error_message = null;

// Click on the password field, show the message
pwd.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

//Click outside the password field, hidde the message
pwd.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// Write in password field
pwd.onkeyup = function() {
    //minus letter
    if (pwd.value.match(/[a-z]/g)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }
    //capital letter
    if (pwd.value.match(/[A-Z]/g)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }
    //digit
    if (pwd.value.match(/[0-9]/g)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
    }
    //length
    if (pwd.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
    if (pwd.value.length <= 30) {
        maximum.classList.remove("invalid");
        maximum.classList.add("valid");
    } else {
        maximum.classList.remove("valid");
        maximum.classList.add("invalid");
    }
}

// Click on the username field, show the message
usr.onfocus = function() {
    document.getElementById("message_usr").style.display = "block";
}

//Click outside the username field, hidde the message
usr.onblur = function() {
    document.getElementById("message_usr").style.display = "none";
}

function check_matches(string, reg) {
    let i = 0;
    while (string[i]) {
        if (!string[i].match(reg))
            return (0);
        i++;
    }
    return (1);
}

usr.onkeyup = function() {
    //letter
    if (check_matches(usr.value, /[a-zA-Z0-9]/)) {
        letter_usr.classList.remove("invalid");
        letter_usr.classList.add("valid");
    } else {
        letter_usr.classList.remove("valid");
        letter_usr.classList.add("invalid");
    }
    //length min
    if (usr.value.length >= 5) {
        min.classList.remove("invalid");
        min.classList.add("valid");
    } else {
        min.classList.remove("valid");
        min.classList.add("invalid");
    }
    //length max
    if (usr.value.length <= 10) {
        max.classList.remove("invalid");
        max.classList.add("valid");
    } else {
        max.classList.remove("valid");
        max.classList.add("invalid");
    }
}

// Click on the confirm field, show the message
confirm.onfocus = function() {
    document.getElementById("message_confirm").style.display = "block";
}

//Click outside the confirm field, hidde the message
confirm.onblur = function() {
    document.getElementById("message_confirm").style.display = "none";
}

confirm.onkeyup = function() {
    //letter
    if (confirm.value == pwd.value) {
        confirmation.classList.remove("invalid");
        confirmation.classList.add("valid");
    } else {
        confirmation.classList.remove("valid");
        confirmation.classList.add("invalid");
    }
}

// Click on the email field, show the message
email.onfocus = function() {
    document.getElementById("message_email").style.display = "block";
}

//Click outside the email field, hidde the message
email.onblur = function() {
    document.getElementById("message_email").style.display = "none";
}

email.onkeyup = function() {
    //verif valide
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
        valide_email.classList.remove("invalid");
        valide_email.classList.add("valid");
    } else {
        valide_email.classList.remove("valid");
        valide_email.classList.add("invalid");
    }
}

/*-------------------------------- DATABASE ---------------------*/

function check_validation() {
    if (usr.value.match(/[a-zA-Z0-9]{5,10}$/)) {
        if (pwd.value.match(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}/)) {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
                if (confirm.value == pwd.value) {
                    return (1);
                } else {
                    error_message = "Invalid Password Confirmation";
                }
            }
            else {
                error_message = "Invalid Email";
            }
        }
        else {
            error_message = "Invalid Password";
        }
    }
    else {
        error_message = "Invalid Username";
    }
    return (0);
}

submit.onclick = function() {
    if (check_validation())
        console.log('ok');
    else
        console.log(error_message);
}