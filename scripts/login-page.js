document.addEventListener('DOMContentLoaded', () => {

  const errorBlock = document.querySelector(".errorBlock");
  const usernameInput = document.querySelector(".inputField[name='usermail']");
  const passwordInput = document.querySelector(".inputField[name='passwd']");

  //Reset form on init
  document.querySelector(".container form").reset()
  const usermail = document.querySelector("input[name='usermail']");
  usermail.value = (GET()['usermail'] != null && GET()['usermail'] != undefined) ? GET()['usermail'] : "";

  //Registeration success
  if(GET()['regstatus'] != undefined && GET()['regstatus'] != null && GET()['regstatus'] == "success") {
    errorBlock.innerHTML = "<span class=\"success\"><i class=\"fa  fa-check\"></i>Account successfuly created.<br/>You can now log in.</span>"
  }

  usernameInput.addEventListener("change", () => {
    usernameInput.classList.remove('error');
    usernameInput.classList.remove('missing');
  });
  
  passwordInput.addEventListener("change", () => {
    passwordInput.classList.remove('error');
    passwordInput.classList.remove('missing');
  });


  // * ERROR HANDLER
  if (GET()['error'] != undefined && GET()['error'] != null) {

    let errorMsg = "";
    let errArr = GET()['error'].split('#');

    // ! INVALID USER OR PASSWORD
    if(errArr.indexOf('invalidlogin') > -1) {
      usernameInput.classList.add("error");
      passwordInput.classList.add("error");
      
      errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Invalid login or password!</span><br/>";


    } else if ((errArr.indexOf('sqlerr') > -1)){

      errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Internal problem occured!</span><br/>";
      
    } else {

      // ! missing user
      if(errArr.indexOf('uE') > -1) {
        usernameInput.classList.add("missing");
        errorMsg +="<span class=\"alert\"><i class=\"fa  fa-warning\"></i>Missing username</span><br/>";
      }
      // ! invalid user
      else if(errArr.indexOf("uI") > -1) {
        usernameInput.classList.add("error");
        errorMsg +="<span class=\"error\"><i class=\"fa  fa-warning\"></i>Invalid username</span><br/>";

      }

      // ! empty password
      if(errArr.indexOf('pE') > -1) {
        passwordInput.classList.add('missing');
        errorMsg += "<span class=\"alert\"><i class=\"fa  fa-warning\"></i>Missing password</span><br/>";
      }
      // ! invalid password
      else if(errArr.indexOf("pI") > -1) {
        passwordInput.classList.add('error');
        errorMsg += "<span class=\"error\"><i class=\"fa  fa-warning\"></i>Invalid password</span><br/>";
      }
    }

    errorBlock.innerHTML = errorMsg;
  }
});
