const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

const inputTitle = document.querySelector("input[name='title']");
const inputEmail = document.querySelector("input[name='email']");
const buttons = document.querySelectorAll("span.edit");
const hiddenConfirmEmail = document.querySelector(".confirmEmail");
const inputConfirmEmail = document.querySelector("input[name='confirmEmail'");
const errorRow = document.querySelector(".errorRow");
const rows = document.querySelectorAll(".row");
const saveButton = document.querySelector("button[type='submit']");
const form = document.querySelector("form");

//Email button even configuration
buttons[1].addEventListener("click", () => {
  if (inputEmail.disabled == true) {

    hiddenConfirmEmail.style.display = "initial";
    inputEmail.disabled = false;
    buttons[1].classList.replace('edit', 'apply');

  } else if (inputEmail.disabled == false) {

    inputEmail.value = inputEmail.value.trim();
    inputConfirmEmail.value = inputConfirmEmail.value.trim();

    if (inputEmail.value != "") {
      if (!emailPattern.test(inputEmail.value)) {
        rows[3].classList.add('error');
        errorRow.innerHTML = "<span class='error'> Provide correct email address</span><br />"
        return;

      } else if (inputEmail.value != inputConfirmEmail.value) {
        errorRow.innerHTML = "<span class='error'> Email addresses doesn't match</span>";
        rows[3].classList.add("error");
        hiddenConfirmEmail.classList.add("error");
        return;
      }
    }
    errorRow.innerHTML = '';
    hiddenConfirmEmail.style.display = "none";
    hiddenConfirmEmail.classList.remove("error");
    rows[3].classList.remove("error");
    buttons[1].classList.replace('apply', 'edit');
    inputEmail.disabled = true;

    if (inputEmail.value != "" || inputTitle.value != "") {
      saveButton.disabled = false;
    } else {
      saveButton.disabled = true;
    }
  }

});

//Title button event configuration
buttons[0].addEventListener("click", () => {
  if (inputTitle.disabled == true) {

    inputTitle.disabled = false;
    buttons[0].classList.replace('edit', 'apply');

  } else if (inputTitle.disabled == false) {

    //test for correct pattern with title definition
    inputTitle.value = inputTitle.value.trim();
    if (inputTitle.value != "" && !/^[A-Za-z0-9_ ]{4,60}$/.test(inputTitle.value)) {
      rows[1].classList.add('error');
      errorRow.innerHTML = "<span class='error'>Title must be like [A-z][0-9][_][ ] and between 4 and 60 letters</span>"
      return;
    }

    errorRow.innerHTML = '';
    rows[1].classList.remove("error");
    inputTitle.disabled = true;
    buttons[0].classList.replace('apply', 'edit');

    if (inputEmail.value != "" || inputTitle.value != "") {
      saveButton.disabled = false;
    } else {
      saveButton.disabled = true;
    }
  }
});

form.addEventListener("submit", (e) => {
  inputEmail.disabled = false;
  inputConfirmEmail.disabled = false;
  inputTitle.disabled = false;
});