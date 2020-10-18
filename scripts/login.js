import { GET } from "./modules/functions.js";

document.addEventListener('DOMContentLoaded', () => {
  const page = GET()['page'];

  if (page == "login") {

    import ('./modules/login-page.js');

  } else if (page == "register") {
    
    import ('./modules/register-page.js');
  }

});
