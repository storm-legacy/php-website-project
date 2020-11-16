import { empty } from './functions.js';
const editProfileUrl = 'php/operations/self-edit-profile.php';

const emailPattern = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g;
const titlePattern = /^[A-Za-z _0-9]{4,30}$/;
const usernamePattern = /^[A-Za-z0-9]{4,30}$/;
const passwdPattern = /^(?=^.{8,50}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?![.\n]).*$/;

//Error handler
const error = {
  list: [],
  errorBlock: document.querySelector('.row.errorRow'),
  printErr: (name = "", type = "", desc = "") => {
    switch (type) {
      case "INFO":
        error.errorBlock.innerHTML += `<div class='errorElement ${name} info'><span class='icon info'></span><span>${desc}</span></div>`;
        break;
      case "WARN":
        error.errorBlock.innerHTML += `<div class='errorElement ${name} warn'><span class='icon warn'></span><span>${desc}</span></div>`;
        break;
      case "ERR":
        error.errorBlock.innerHTML += `<div class='errorElement ${name} err'><span class='icon err'></span><span>${desc}</span></div>`;
        break;
    }
  },
  add: (name = "", type = "WARN", desc = "none") => {

    if(empty(error.list[name])) {
      error.list[name] = [type, desc];
      error.printErr(name, type, desc);

    } else {

      const query = `.errorElement.${name}`;
      const elem = document.querySelector(query);
      elem.remove();
      error.list[name] = [type, desc];
      error.printErr(name, type, desc);
    }
  },
  remove: (name = "") => {
    if(!empty(error.list[name])) {
      const query = `.errorElement.${name}`;
      const elem = document.querySelector(query);
        elem.remove();
        error.list[name] = "";
    }
  }

};


//Title row operation
const title = {
  status: false,
  input: document.querySelector(".row input[name='title']"),
  button: document.querySelector(".row span.editTitle"),
  sendXHTTP: () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
        title.input.placeholder = title.input.value;
        document.querySelector('.profileBlock span.title').innerHTML = title.input.value;
        title.input.value = "";

      } else if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == false) {
        title.input.value = "";
        error.add('title', 'ERR', "Internal error occured. Try again!");

      } else if (xhttp.readyState == 4 && xhttp.status == 200) {
        title.input.value = "";
        error.add('title', 'ERR', xhttp.responseText);
      }
    };
    xhttp.open("POST", editProfileUrl, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`title=${title.input.value}`);
  },
  openMenu: () => { title.status = true; title.input.disabled = false; title.button.classList.remove('edit-time'); title.button.classList.add('confirm'); },
  closeMenu: () => { title.status = false; title.input.disabled = true; title.button.classList.remove('confirm'); title.button.classList.add('edit-time'); },
  switchMenu: () => {
    if(!title.status) {
      title.openMenu();
    } else {
      if (empty(title.input.value)) {
        error.remove('title');
        title.closeMenu();

      } else if (titlePattern.test(title.input.value)){
        error.remove('title');
        title.closeMenu();
        title.sendXHTTP();
      } else {
        const errMsg = "Title cannot be less than 4 and longer than 30 character and can contain only letters, numbers spaces and underscores";
        error.add('title', "WARN", errMsg);
      }
    }
  }
};
title.button.addEventListener('click', title.switchMenu);


//Username row operation
const username = {
  status: false,
  input: document.querySelector(".row input[name='username']"),
  button: document.querySelector(".row span.editUsername"),
  sendXHTTP: () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
        username.input.placeholder = username.input.value;
        document.querySelector('.profileBlock span.username').innerHTML = '@' + username.input.value;
        username.input.value = "";

      } else if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == false) {
        username.input.value = "";
        error.add('username', 'ERR', "Internal error occured. Try again!");

      } else if (xhttp.readyState == 4 && xhttp.status == 200) {
        username.input.value = "";
        error.add('username', 'ERR', xhttp.responseText);
      }
    };
    xhttp.open("POST", editProfileUrl, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`username=${username.input.value}`);
  },
  openMenu: () => { username.status = true; username.input.disabled = false; username.button.classList.remove('edit-time'); username.button.classList.add('confirm'); },
  closeMenu: () => { username.status = false; username.input.disabled = true; username.button.classList.remove('confirm'); username.button.classList.add('edit-time'); },
  switchMenu: () => {
    if (!username.status) {
      username.openMenu();
    } else {
      if (empty(username.input.value)) {
        error.remove('username');
        username.closeMenu();
        
      } else if (usernamePattern.test(username.input.value)) {
        error.remove('username');
        username.closeMenu();
        username.sendXHTTP();

      } else {
        const errMsg = "Username must contain only letters and numbers and must be between 4 and 30 characters";
        error.add('username', 'ERR', errMsg);
      }
    }
  }
};
username.button.addEventListener('click', username.switchMenu);


//Email row operation
const email = {
  status: false,
  input: document.querySelector(".row input[name='email']"),
  confirmRow: document.querySelector(".row.confirmEmailRow"),
  confirmInput: document.querySelector(".row input[name='confirmEmail']"),
  button: document.querySelector(".row span.editEmail"),
  sendXHTTP: () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
        email.input.placeholder = email.input.value;
        email.confirmInput.placeholder = email.input.value;
        email.input.value = "";
        email.confirmInput.value = "";

      } else if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == false) {
        email.input.value = "";
        email.confirmInput.value = "";
        error.add('email', 'ERR', "Internal error occured. Try again!");

      } else if (xhttp.readyState == 4 && xhttp.status == 200) {
        email.input.value = "";
        email.confirmInput.value = "";
        error.add('email', 'ERR', xhttp.responseText);
      }
    };
    xhttp.open("POST", editProfileUrl, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`email=${email.input.value}&confirmEmail=${email.confirmInput.value}`);
  },
  openMenu: () => {
    email.status = true;
    email.input.disabled = false;
    email.confirmRow.classList.remove("hidden");
    email.button.classList.remove('edit-time');
    email.button.classList.add('confirm');
  },

  closeMenu: () => {
    email.status = false;
    email.input.disabled = true;
    email.confirmRow.classList.add("hidden");
    email.button.classList.remove('confirm');
    email.button.classList.add('edit-time');
  },

  switchMenu: () => {
    if (!email.status) {
      email.openMenu();
    } else {
      if (empty(email.input.value) && empty(email.confirmInput.value)) {
        error.remove('email');
        email.closeMenu();
      } else {
        if (emailPattern.test(email.input.value) || emailPattern.test(email.confirmInput.value)) {
          if(email.input.value === email.confirmInput.value) {
            error.remove('email');
            email.closeMenu();
            email.sendXHTTP();
          } else {
            const errMsg = "E-mails are not similar.";
            error.add('email', 'ERR', errMsg);
          }

        } else {
          const errMsg = "E-mail is incorrect";
          error.add('email', 'ERR', errMsg);
        }
      }
    }
  }
};
email.button.addEventListener('click', email.switchMenu);

//Passwd row operation
const passwd = {
  status: false,
  input: document.querySelector(".row input[name='passwd']"),
  confirmRow: document.querySelector(".row.confirmPasswordRow"),
  confirmInput: document.querySelector(".row input[name='confirmPasswd']"),
  button: document.querySelector(".row span.editPasswd"),
  sendXHTTP: () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
        passwd.input.value = "";
        passwd.confirmInput.value = "";
        error.add('passwd', 'INFO', 'Password succesfully changed!');

      } else if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == false) {
        passwd.input.value = "";
        passwd.confirmInput.value = "";
        error.add('passwd', 'ERR', "Internal error occured. Try again!");

      } else if (xhttp.readyState == 4 && xhttp.status == 200) {
        passwd.input.value = "";
        passwd.confirmInput.value = "";
        error.add('passwd', 'ERR', xhttp.responseText);
      }
    };
    xhttp.open("POST", editProfileUrl, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`passwd=${passwd.input.value}&confirmPasswd=${passwd.confirmInput.value}`);
  },
  openMenu: () => {
    passwd.status = true;
    passwd.input.disabled = false;
    passwd.confirmRow.classList.remove("hidden");
    passwd.button.classList.remove('edit-time');
    passwd.button.classList.add('confirm');
  },

  closeMenu: () => {
    passwd.status = false;
    passwd.input.disabled = true;
    passwd.confirmRow.classList.add("hidden");
    passwd.button.classList.remove('confirm');
    passwd.button.classList.add('edit-time');
  },

  switchMenu: () => {
    if (!passwd.status) {
      passwd.openMenu();
    } else {
      if (empty(passwd.input.value) && empty(passwd.confirmInput.value)) {
        passwd.closeMenu();
      } else {
        if (passwd.input.value.length < 8 || passwd.confirmInput.value.length < 8) {
          const errMsg = 'Password is too short!';
          error.add('passwd', "ERR", errMsg);
        } else {
          if(passwd.input.value !== passwd.confirmInput.value) {
            const errMsg = "Passwords mismatched!";
            error.add('passwd', "ERR", errMsg);
          } else {
            if(!passwdPattern.test(passwd.input.value)) {
              const errMsg = "Password must contain at least one uppercase letter and number";
              error.add('passwd', 'ERR', errMsg);
            } else {
              //everything is fine
              error.remove('passwd');
              passwd.closeMenu();
              passwd.sendXHTTP();
            }
          }
        }
      }
    }
  }
};
passwd.button.addEventListener('click', passwd.switchMenu);


const avatarDrop = document.querySelector('.avatarImg');
const avatar = {
  allowed_img_types: ['image/png', 'image/jpeg', 'image/jpg'],
  avatar_file: {},
  dropEvent: (e) => {
    e.preventDefault();
    e.stopPropagation();

    const file = e.dataTransfer.files[e.dataTransfer.files.length - 1];
    if(avatar._checkFile(file)) {
      avatar.avatar_file = file;
      avatar._sendRequest();
    }

  },
  dragenter: (e) => {
    e.preventDefault();
    e.stopPropagation();
  },
  dragleave: (e) => {
    e.preventDefault();
    e.stopPropagation();
  },
  dragover: (e) => {
    e.preventDefault();
    e.stopPropagation();
  },
  _checkFile: (file) => {
    if(avatar.allowed_img_types.indexOf(file.type) == -1) {
      alert('Allowed iamge types: [PNG,JPG,JPEG]');
      return false;
    } else if (file.size > 512000000) {
      alert('File is larger than 512KB');
      return false;
    }
    else {
      return true;
    }
  },
  _sendRequest: () => {
    const formData = new FormData();
    formData.append('avatar_img', avatar.avatar_file);

    const xhttp = new XMLHttpRequest();
    const errBlock = document.querySelector('.errorBlock');
    const errTitle = document.querySelector('.errorBlock .errorMsg span.title');
    const errDesc = document.querySelector('.errorBlock .errorMsg span.desc');
    const errButton = document.querySelector('.errorBlock .errorMsg button');
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 1) {
        errTitle.innerHTML = 'Upload status';
        errDesc.innerHTML = 'Avatar is currently being uploaded!';
        errButton.disabled = true;
        errBlock.style.display = 'flex';
      } else if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
        errTitle.innerHTML = 'Avatar uploaded!';
        let seconds = 3;
        let timer = setInterval(() => {
          errDesc.innerHTML = 'Your page will be refreshed in ' + seconds--;
          if (seconds == 0) {
            window.location.reload();
          }
        }, 1000)
      } else if (xhttp.readyState == 4 && xhttp.status == 200) {
        errTitle.innerHTML = 'Internal error!';
        errDesc.innerHTML = 'There are temporary problems. Please try again later!<br/>';
        if (xhttp.responseText != false) {
          errDesc.innerHTML += xhttp.responseText;
        }
      }
    }
    xhttp.open('POST', 'php/operations/self-edit-profile.php', true);
    xhttp.send(formData);
  }
};
avatarDrop.addEventListener("dragenter", avatar.dragenter);
avatarDrop.addEventListener("dragleave", avatar.dragleave);
avatarDrop.addEventListener("dragover", avatar.dragover);
avatarDrop.addEventListener("drop", avatar.dropEvent);