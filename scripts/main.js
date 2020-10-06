const widthSubmenu = "240px";
let menuActive = false;

//AFTER WEBPAGE IS LOADED
document.addEventListener("DOMContentLoaded", () => {

  const submenuButton_header = document.querySelector(".submenu-button-header");
  const submenuButton_bar = document.querySelector(".submenu-button-submenu");
  const submenu = document.querySelector("aside");

  let menuItems = document.querySelectorAll(".menu ul li a");
  menuItems.forEach(elem => {
    elem.classList.remove("active");
  });

  // Give menu item active class
  let query = "";
  if (GET()['page'] != undefined && GET()['page'] != null) {
    query = "." + GET()['page'];
    let elem = document.querySelector(query);

    //small fix to prevent uneccessery error
    if(elem != null) {
      elem.classList.add('active');
    }
  }


  //switch menu function
  const switchSubmenu = (value) => {

    if(value == 0 | value == 1)
      menuActive = value;

    if (menuActive == false) {
      submenu.style.width = widthSubmenu;
      menuActive = true;
    } else if (menuActive == true) {
      submenu.style.width = "0px";
      menuActive = false;
    }
  }


  //Click event for submenu button
  submenuButton_header.addEventListener("click", switchSubmenu);
  submenuButton_bar.addEventListener("click", switchSubmenu);



});