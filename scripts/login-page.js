document.addEventListener('DOMContentLoaded', () => {

  //Reset form on init
  document.querySelector(".container form").reset()
  const usermail = document.querySelector("input[name=usermail]");
  usermail.value = (GET()['usermail'] != null && GET()['usermail'] != undefined) ? GET()['usermail'] : "";

});
