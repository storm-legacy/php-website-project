document.addEventListener('DOMContentLoaded', () => {

  //Reset form on init
  document.querySelector(".container form").reset()
  const termsOfUsage = document.querySelector(".termsOfUsage");
  const emailField = document.querySelector("input[name=email]");
  const usernameField = document.querySelector("input[name=username]");

  emailField.value = (GET()['email'] != null && GET()['email'] != undefined) ? GET()['email'] : "";
  usernameField.value = (GET()['username'] != null && GET()['username'] != undefined) ? GET()['username'] : "";

  // SHOW NEW WINDOW WITH TERMS OF USAGE
  termsOfUsage.addEventListener("click", () => {
    let termsWindow = window.open("../terms.php", "TERMS OF USAGE", "width=500, height=600");
  });



});