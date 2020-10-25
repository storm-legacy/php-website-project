import('./modules/functions.js');
import { GET } from './modules/functions.js';
import { ProfileMenu, UploadMenu } from './modules/menuHandler.js';
import { PrintVideos } from './modules/print-videos.js';

const url = "/api/video-list.php";

document.addEventListener("DOMContentLoaded", () => {
  const page = GET()['page'];

  let topBarHandler = ({});

  const profileButton = document.querySelector('.profileButton');
  const profileBlock = document.querySelector('.profileBlock');
  const profile_menu = new ProfileMenu(profileButton, profileBlock);
  
  const uploadButton = document.querySelector('.uploadButton');
  const uploadBlock = document.querySelector('.uploadBlock');
  const upload_menu = new UploadMenu(uploadButton, uploadBlock);

  if(page == "home" || page == '' || page == undefined) {
    const pV = new PrintVideos(url, document.querySelector('.wrapperBrowser'));
    pV.printList(0);
  }

});