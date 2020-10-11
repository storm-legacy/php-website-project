const widthSubmenu = "245px";
let menuActive = false;

//AFTER WEBPAGE IS LOADED
document.addEventListener("DOMContentLoaded", () => {

  const submenuButton_header = document.querySelector(".submenu-button-header");
  const submenuButton_bar = document.querySelector(".submenu-button-submenu");
  const submenu = document.querySelector(".submenuContainer");

  let menuItems = document.querySelectorAll(".userPanel ul li a");
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


  //PRINT PERMISSIONS ERROR
  if(GET()['error'] == "insufficientpermissions") {
    const errorBlock = document.querySelector(".errorBlock");
    const errorType = document.querySelector(".errorBlock .errorMsg span.title");
    const errorDesc = document.querySelector(".errorBlock .errorMsg span.desc");
    const errorButton = document.querySelector(".errorBlock .errorMsg button");

    errorType.innerHTML = '<i class=\"fa fa-warning\"></i> Error';
    errorDesc.innerHTML = 'You do not have permissions to access that page!';

    errorBlock.style.display = 'flex';
    errorButton.addEventListener("click", () => {
      errorBlock.style.display = 'none';
    });

  }


  //switch menu function
  const switchSubmenu = (value) => {

    if(value == 0 | value == 1)
      menuActive = !value;

    if (menuActive == false) {
      submenu.style.minWidth = widthSubmenu;
      submenu.style.width = widthSubmenu;
      menuActive = true;
    } else if (menuActive == true) {
      submenu.style.minWidth = "0px";
      submenu.style.width = "0px";
      menuActive = false;
    }
  }
  switchSubmenu(menuActive);


  //Click event for submenu button
  submenuButton_header.addEventListener("click", switchSubmenu);
  submenuButton_bar.addEventListener("click", switchSubmenu);



});