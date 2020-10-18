document.addEventListener("DOMContentLoaded", () => {

  const video = document.querySelector(".video");
  const progress = document.querySelector(".progress");
  const playButton = document.querySelector(".play-pause");


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

});