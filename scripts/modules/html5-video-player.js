import {GET} from "./functions.js";

const video = document.querySelector(".video");
const progress = document.querySelector(".progress");
const playButton = document.querySelector(".play-pause");
const likeButton = document.querySelector(".icon.plus");
const dislikeButton = document.querySelector(".icon.minus");
const rating = document.querySelector("div.rating span.value");
const postCommentButton = document.querySelector("button.postCommentButton");
const commentList = document.querySelector(".commentList");


//Popup
const BlackScreen = document.querySelector(".blackScreen");
const popup = document.querySelector(".blackScreen .popup");
const commentBlock = document.querySelector(".blackScreen .popup .comment-block");
const commID = document.querySelector("input.commID");
const confirmButton = document.querySelector(".popup button.confirmCommentDelete");
const confirmVideoDelButton = document.querySelector(".popup button.confirmVideoDelete");
confirmButton.style.display = 'none';
confirmVideoDelButton.style.display = 'none';

document.querySelector(".blackScreen .popup button.cancel").addEventListener("click", () => {
  BlackScreen.style.display = "none";
  commentBlock.innerHTML = "";
});

//Video delete
const delButton = document.querySelector('div.deletion-block');
delButton.addEventListener('click', () => {
  const videoID = GET()['link'];
  document.querySelector('span.notify').innerHTML = 'Confirm video deletion';
  commID.value = videoID;
  confirmButton.style.display = 'none';
  confirmVideoDelButton.style.display = 'initial';
  BlackScreen.style.display = "flex";

  const func = () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
        if (xhttp.responseText == true) {
          confirmVideoDelButton.removeEventListener("click", func);
          BlackScreen.style.display = "none";
          window.location.href = 'index.php?page=home&status=delsuccess';
        } else {
          alert(xhttp.responseText);
          BlackScreen.style.display = "none";
          confirmVideoDelButton.removeEventListener("click", func);
          BlackScreen.style.display = "none";
          alert("Video could not been deleted.");
        }
      }
    }
    xhttp.open("POST", "php/operations/self-remove-video.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(`videoID=${videoID}`);
  }
  confirmVideoDelButton.addEventListener("click", func);
})

video.volume = 0.2;

const url = "php/operations/self-rate-video.php";
const xhttp = new XMLHttpRequest();
const videoID = GET()['link'];

const editRating = (mode) => {
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  let operation = "";
  switch(mode) {
    case "up":
      rating.innerHTML = Number(rating.innerHTML) + Number(1);
      rating.classList.add("liked");
      likeButton.classList.add("active");
      operation = "like";
      break;

    case "down":
      rating.innerHTML = Number(rating.innerHTML) - Number(1);
      rating.classList.add("disliked");
      dislikeButton.classList.add("active");
      operation = "dislike";
      break;

    case "reset":
      if(rating.classList.contains("disliked")) {
        rating.innerHTML = Number(rating.innerHTML) + Number(1);
        rating.classList.remove("disliked");
        dislikeButton.classList.remove("active");

      } else if (rating.classList.contains("liked")) {
        rating.innerHTML = Number(rating.innerHTML) - Number(1);
        rating.classList.remove("liked");
        likeButton.classList.remove("active");
      }
      operation = "unselect";
      break;
  }

  xhttp.send(`videoID=${videoID}&operation=${operation}`);
}

likeButton.addEventListener("click", () => {
  if(rating.classList.contains("disliked")) {
    editRating("reset");
    editRating("up");
  } else if(!rating.classList.contains("liked")){
    editRating("up");
  } else {
    editRating("reset");
  }
});

dislikeButton.addEventListener("click", () => {
  if (rating.classList.contains("liked")) {
    editRating("reset");
    editRating("down");
  } else if (!rating.classList.contains("disliked")) {
    editRating("down");
  } else {
    editRating("reset");
  }
});


//Play-Pause button handler
playButton.addEventListener("click", () => {
  if(video.paused) {
    playButton.className = 'pause';
    video.play();
  } else {
    playButton.className = 'play';
    video.pause();
  }
});

video.addEventListener("timeupdate", () => {
  let progressPos = video.currentTime / video.duration;
  progress.style.width = (progressPos * 100) + '%';
  if(video.ended) {
    playButton.className = 'play';
  }
});

video.addEventListener("contextmenu", (e) => {
  e.preventDefault();
});;

// comment deletion handler
const trashButtons = document.querySelectorAll("span.icon.trash");

if(trashButtons.length > 0) {
  trashButtons.forEach(elem => {
    
    //comment delete button
    elem.addEventListener("click", () => {
      let query = '.comment-block-' + elem.id;
      commentBlock.innerHTML = document.querySelector(query).innerHTML;
      commID.value = elem.id;
      document.querySelector('span.notify').innerHTML = 'Confirm comment deletion';
      confirmButton.style.display = 'initial';
      confirmVideoDelButton.style.display = 'none';
      BlackScreen.style.display = "flex";

      const func = () => {
        commentBlock.innerHTML = "";
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = () => {
          if(xhttp.readyState == 4 && xhttp.status == 200) {
            if(xhttp.responseText == true) {

              let query = '.comment-block-' + elem.id;
              document.querySelector(query).remove();
              confirmButton.removeEventListener("click", func);
              BlackScreen.style.display = "none";

            } else {
              BlackScreen.style.display = "none";
              confirmButton.removeEventListener("click", func);
              BlackScreen.style.display = "none";
              alert("Comment could not been deleted. Refresh page and try again!");
            }
          }
        }
        xhttp.open("POST", "php/operations/self-remove-comment.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(`commentID=${elem.id}`);
      }
      confirmButton.addEventListener("click", func);
    });
  });
}

//Place comment with js and add to database
postCommentButton.addEventListener("click", () => {
  const commentContent = document.querySelector("textarea").value;
  document.querySelector("textarea").value = "";
  if(commentContent == "" || commentContent == null || commentContent == undefined)
    return;
    
  const video_id = GET()['link'];
  
  
  //send information to database
  const xhttp = new XMLHttpRequest();

  //Jeśli dodawanie zakończyło się sukcesem
  xhttp.onreadystatechange = () => {
    if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText == true) {
      const user_avatar = document.querySelector(".personalComment .avatar img").src;
      const username = document.querySelector(".personalComment .username").innerHTML;

      const now = new Date();
      let day = now.getDay();
      let month = now.getMonth();
      let year = now.getFullYear();
    
      let hour = now.getHours();
      let minute = now.getMinutes()
    
      if(day < 10)
        day = '0' + day;
      if(month < 10)
        month = '0' + month;
      if(year < 10)
        year = '0' + year;
      if(hour < 10)
        hour = '0' + hour;
      if(minute < 10)
        minute = '0' + minute;
    
      let postDate = year + "-" + month + '-' + day + ' ' + hour + ":" + minute;
    
      commentList.innerHTML = `<div class='comment-block'><span class="icon trash"></span><img class='avatar' alt='avatar' src='${user_avatar}' />` +
        `<div><div><span class='username'>${username}</span><span class='post-date'>${postDate}</span></div><span class='content'>${commentContent}</span></div></div>` + commentList.innerHTML;

        
    }
  }
  xhttp.open("POST", "php/operations/self-comment-video.php", true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send(`content=${commentContent}&videoID=${video_id}`);

});
