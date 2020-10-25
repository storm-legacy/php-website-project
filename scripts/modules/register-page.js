import { GET } from './functions.js';

console.log('register');
//Reset form on init
document.querySelector(".container form").reset()

// Declare objects
const termsOfUsage = document.querySelector(".termsOfUsage");
const emailField = document.querySelector("input[name=email]");
const usernameField = document.querySelector("input[name=username]");
const passwd1Field = document.querySelector("input[name='passwd_1']");
const passwd2Field = document.querySelector("input[name='passwd_2']");
const errorBlock = document.querySelector(".errorBlock");

// Reset fields
emailField.addEventListener("change", () => {
  emailField.classList.remove('error');
  emailField.classList.remove('missing');
});

usernameField.addEventListener("change", () => {
  usernameField.classList.remove('error');
  usernameField.classList.remove('missing');
});

passwd1Field.addEventListener("change", () => {
  passwd1Field.classList.remove('error');
  passwd1Field.classList.remove('missing');
});

passwd2Field.addEventListener("change", () => {
  passwd2Field.classList.remove('error');
  passwd2Field.classList.remove('missing');
});


// GET valid credentials
emailField.value = (GET()['email'] != null && GET()['email'] != undefined) ? GET()['email'] : "";
usernameField.value = (GET()['username'] != null && GET()['username'] != undefined) ? GET()['username'] : "";

// SHOW NEW WINDOW WITH TERMS OF USAGE
termsOfUsage.addEventListener("click", () => {
  let termsWindow = window.open("../terms.php", "TERMS OF USAGE", "width=500, height=600");
});


// * ERROR HANDLER
if (GET()['error'] != undefined && GET()['error'] != null) {

  let errorMsg = "";
  let errArr = GET()['error'].split('^');

  // ! missing email
  if (errArr.indexOf("eE") > -1) {
    emailField.classList.add('missing');
    errorMsg += "<span class=\"alert\"><i class=\"fa  fa-warning\"></i>Missing email</span><br/>";

    // ! invalid email
  } else if (errArr.indexOf("eI") > -1) {
    emailField.classList.add('error');
    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Invalid email</span><br/>";

    // ! email taken
  } else if (errArr.indexOf("eT") > -1) {
    emailField.classList.add('error');
    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Email already taken</span><br/>";
  }


  // ! missing user
  if (errArr.indexOf('uE') > -1) {
    usernameField.classList.add('missing');
    errorMsg += "<span class=\"alert\"><i class=\"fa  fa-warning\"></i>Missing username</span><br/>";

    // ! invalid user
  } else if (errArr.indexOf("uI") > -1) {
    usernameField.classList.add('error');
    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Username must be between 4 and 30 letters (0-9, A-z)</span><br/>";

    // ! user taken
  } else if (errArr.indexOf("uT") > -1) {
    usernameField.classList.add('error');
    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Username already taken</span><br/>";
  }


  // ! empty password
  if (errArr.indexOf('pE') > -1) {
    passwd1Field.classList.add('missing');
    passwd2Field.classList.add('missing');
    errorMsg += "<span class=\"alert\"><i class=\"fa  fa-warning\"></i>Missing password</span><br/>";

    // ! invalid password
  } else if (errArr.indexOf("pI") > -1) {
    passwd1Field.classList.add('error');
    passwd2Field.classList.add('error');
    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Password must be between 8 and 50 characters (at least one -> 0-9, A-Z, a-z)</span><br/>";

    // ! password missmatched
  } else if (errArr.indexOf("pM") > -1) {
    passwd1Field.classList.add('error');
    passwd2Field.classList.add('error');
    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Passwords mismatched</span><br/>";
  }


  // ! terms denied
  if (errArr.indexOf('tD') > -1) {

    errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Terms of use denied</span><br/>";
  }

  errorBlock.innerHTML = errorMsg;
}