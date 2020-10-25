export class PrintVideos {

  constructor(url, videoDiv) {
    this.url = url;
    this.contentArea = videoDiv;
    this.jsonObj = ({});
    this.xhttp = new XMLHttpRequest();
    this.currentTime = new Date();

    //execute when response arrives
    this.xhttp.onreadystatechange = () =>{
      if (this.xhttp.readyState == 4 && this.xhttp.status == 200) {

        this._parseJson(this.xhttp.responseText); //insert values into Json object
        this.jsonObj.forEach(item => {
          this._printVideo(item);
        });
      }
    }
  }
  
  //send POST resquest
  _execute = (offset) => {
    this.xhttp.open("POST", this.url, true);
    this.xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhttp.send(`offset=${offset}`);
  }

  _parseJson = (string) => {
    this.jsonObj = JSON.parse(string);
  }

  _prettyDuration = (valueInSeconds) => {
    valueInSeconds = Number(valueInSeconds);
    let h = Math.floor(valueInSeconds / 3600);
    let m = Math.floor(valueInSeconds % 3600 / 60);
    let s = Math.floor(valueInSeconds % 3600 % 60);

    if(h < 10) h = "0" + h;
    if(m < 10) m = "0" + m;
    if(s < 10) s = "0" + s;

    if(valueInSeconds < 3600)
      return m + ":" + s;
    else 
      return h + ":" + m + ":" + s;
  }

  
  _prettyViewCount = (value) => {
    if(value < 1000)
      return value;
    else if(value < 10000)
      return Math.floor(value / 1000) + "." + Math.floor(value % 1000 / 100) + "k";
    else if(value < 1000000)
      return Math.floor(value / 1000) + "k";
    else if(value < 10000000)
      return Math.floor(value /1000000 ) + "." + Math.floor(value % 1000000 / 100000) + "m";
    else if(value < 1000000000)
      return Math.floor(value / 1000000) + "m";

    //no bilion because developement sample
  }

  _prettyDate = (value) => {
    let videoTime = new Date(value);
    let diff = Math.floor((this.currentTime.getTime() - videoTime.getTime()) / 1000);

    if(diff < 60) return "now";
    else if(diff < (2 * 60)) return "1 minute ago" ;
    else if(diff < (60 * 60)) return Math.floor(diff / 60) + " minutes ago";
    else if(diff < (60 * 60 * 2)) return "1 hour ago";
    else if(diff < (60 * 60 * 24)) return Math.floor(diff / 3600) + " hours ago";
    else if(diff < (3600 * 24 * 2)) return "1 day ago";
    else if(diff < (3600 * 24 * 30)) return Math.floor(diff / 3600 * 24) + " days ago";
    else if(diff < (3600 * 24 * 30 * 2)) return "1 month ago";
    else if (diff < (3600 * 24 * 30 * 12)) return Math.floor(diff / 3600 * 24 * 30) + " months ago";
    else if(diff < (3600 * 24 * 30 * 12 * 2)) return "1 year ago";
    else return Math.floor(diff / (3600 * 24 * 30 * 12)) + " years ago";
  }

  _printVideo = (values) => {
    let videoBlock = `<div class="video-block"><a href="?page=video&link=${values['id']}">`;
    videoBlock += `<img class="thumbnail" src="usr_files/thumbnails/${values['thumbnail_file']}" alt="thumbnail" />`
    videoBlock += `<span class="title">${values['title']}</span><span class="duration">${this._prettyDuration(values['duration'])}</span></a>`;
    videoBlock += `<div class="info"><a href=""><span class="author">@${values['author']}</span></a>`;
    videoBlock += `<span class="views">${this._prettyViewCount(values['views'])} views</span><span class="upload-date">  ${this._prettyDate(values['date'])} </span>`
    videoBlock += `</div>`

    this.contentArea.innerHTML += videoBlock;
  }

  printList = (offset = 0) => {
    this._execute(offset);
  }

  

}