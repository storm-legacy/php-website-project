import { empty } from "./functions.js";

export class DropdownUpload {
  allowedTypes = ['png', 'jpeg', 'jpg'];
  titlePattern = /^(.{4,100})$/;
  descPattern = /^(.{4,480})$/;

  constructor(dropdownBlock, thumbnailDrop, titleInput, descInput) {
    this.dropdownBlock = dropdownBlock;
    this.thumbnailDrop = thumbnailDrop;
    this.titleInput = titleInput;
    this.descInput = descInput;
    this.locked = false;
    this.thumbnailFile = {};
    this.videoFile = {};

    if(window.File && window.FileReader && window.FileList && window.Blob) {

      dropdownBlock.addEventListener("dragenter", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.dropdownBlock.classList.add("highlight");
      });

      dropdownBlock.addEventListener("dragleave", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.dropdownBlock.classList.remove("highlight");
      });

      dropdownBlock.addEventListener("dragover", (e) => {
        e.preventDefault();
        e.stopPropagation();
      });

      dropdownBlock.addEventListener("drop", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const file = e.dataTransfer.files[e.dataTransfer.files.length - 1];
        if (
          this.titlePattern.test(this.titleInput.value) &&
          this.descPattern.test(this.descPattern.value) &&
          !empty(this.thumbnailFile) &&
          (file.type == "video/mp4")
          ) {
            this.videoFile = file;
            this._sendFile(this.videoFile, this.thumbnailFile);

          } else {
            alert('File upload unavailable!');
          }
      });

      //thumnailUpload
      thumbnailDrop.addEventListener("dragenter", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.thumbnailDrop.classList.add("highlight");
      });

      thumbnailDrop.addEventListener("dragleave", (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.thumbnailDrop.classList.remove("highlight");
      });

      thumbnailDrop.addEventListener("dragover", (e) => {
        e.preventDefault();
        e.stopPropagation();      
      });

      thumbnailDrop.addEventListener("drop", (e) => {
        e.preventDefault();
        e.stopPropagation();
          this.thumbnailDrop.classList.remove('highlight');
          let correctImage = false;
          const file = e.dataTransfer.files[e.dataTransfer.files.length - 1];

          this.allowedTypes.forEach(item => {
            if (file.type == 'image/' + item)
              correctImage = true;
          });
        
          if(correctImage) {
            this.thumbnailFile = file;
            this.thumbnailDrop.classList.add('uploaded');
          }

          console.log(e.dataTransfer.files);
          console.log(this.thumbnailFile);
      });
    }
  }
  
  _sendFile = (file, thumbnail) => {
    const data = new FormData();
    if(!empty(this.titleInput.value) && !empty(this.descInput.value)) {
      data.append('videoTitle', this.titleInput.value);
      data.append('videoDesc', this.descInput.value);
      data.append('thumbnail_file', thumbnail);
      data.append('video_file', file);
    }

    const errBlock = document.querySelector('.errorBlock');
    const errTitle = document.querySelector('.errorBlock .errorMsg span.title');
    const errDesc = document.querySelector('.errorBlock .errorMsg span.desc');
    const errButton = document.querySelector('.errorBlock .errorMsg button');
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if(xhttp.readyState == 1) {
        errTitle.innerHTML = 'Upload status';
        errDesc.innerHTML = 'Your video is curently being uploaded. Do not close your browser page!';
        errButton.disabled = true;
        errBlock.style.display = 'flex';
      } else if (xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
        errTitle.innerHTML = 'Video uploaded!';
        let seconds = 5;
        let timer = setInterval(() => {
          errDesc.innerHTML = 'You will be redirected to main page in ' + seconds--;
          if(seconds == 0) {
            let string = this.titleInput.value.replace(/ /g, "+");
            window.location.href = `index.php?page=home&search=${string}`;
          }
        }, 1000)
      } else if (xhttp.readyState == 4 && xhttp.status == 200) {
        errTitle.innerHTML = 'Internal error!';
        errDesc.innerHTML = 'There are temporary problems. Please try again later!<br/>';
        if(xhttp.responseText != false) {
          errDesc.innerHTML += xhttp.responseText;
        } 
      }
    }

    xhttp.open("POST", "php/operations/upload-video.php", true);
    xhttp.send(data);
  }

}