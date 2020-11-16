import('./modules/functions.js');
import { empty, GET } from './modules/functions.js';
import { ProfileMenu, UploadMenu } from './modules/menuHandler.js';
import { PrintVideos } from './modules/print-videos.js';
import { DropdownUpload } from './modules/dropdown-upload.js';

const url = "/api/video-list.php";

document.addEventListener("DOMContentLoaded", () => {
  const page = GET()['page'];

  const pV = new PrintVideos(url, document.querySelector('.wrapperBrowser'));

  const mainGrid = document.querySelector('.mainGrid');
  const profileButton = document.querySelector('.profileButton');
  const profileBlock = document.querySelector('.profileBlock');
  const profile_menu = new ProfileMenu(profileButton, profileBlock);
  
  const uploadButton = document.querySelector('.uploadButton');
  const uploadBlock = document.querySelector('.uploadBlock');
  const upload_menu = new UploadMenu(uploadButton, uploadBlock);

  const searchInput = document.querySelector(".searchBox input");
  const searchButton = document.querySelector(".searchBox span.search");

  const search = () => {
    const string = searchInput.value;

    if (string == "%self%") {
      pV.printByUsername("%self%");
    } else {
      pV.printByString(string);
    }
  }

  searchButton.addEventListener("click", search);
  document.addEventListener("keypress", (e) => {
    if(e.code == "Enter" && (document.activeElement == document.querySelector("input#searchBoxInput"))) {
      search();
    }
  });

  //dirty workaround
  if(page !== "home" && page !== undefined && page !== null) {
    document.querySelector(".homeButton").addEventListener("click", () => {
      window.location.href = "index.php?page=home";
    });
  }
  if(page !== "upload") {
    document.querySelector('.uploadButton').addEventListener('click', () => { window.location.href = "index.php?page=upload"; });
  }

  //end of dirty workaround

  if(page === "home" || page == '' || page == undefined) {
    mainGrid.classList.remove("slim");
    pV.printByOffset(0);

    if (!empty(GET()['search'])) {
      let value = GET()['search'];
      value = value.replace(/[+]/g, " ");

      if(value == "%self%") {
        searchInput.value = value;
        pV.printByUsername("%self%");
        console.log(value);
      } else {
        searchInput.value = value;
        pV.printByString(value);
      }

    }

  } else if (page === "video") {
    import('./modules/html5-video-player.js');
  } else if (page === "profile-edit") {
    import('./modules/profile.js');
  } else if(page === "upload") {
    const dropdownUpload = new DropdownUpload(
      document.querySelector('.dropdown'), //dropdown for video
      document.querySelector('.thumbnailDropdown'), //thumbnail
      document.querySelector('input.uploadedVideoTitle'), //video Title
      document.querySelector('textarea.uploadedVideoDesc'), //video desc
      );
  }

});