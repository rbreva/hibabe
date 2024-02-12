let menuBtn = document.querySelector(".menu_mob");
let navBar = document.querySelector("#nav_bar");

let menuLat = document.querySelector(".nav_bar_lat");
let menuLatBtn = document.querySelector(".nav_bar_lat_btn");
let arrowLat = document.querySelector(".arrow_lat");

let container = document.querySelector(".container");

menuBtn.addEventListener("click", () => {
  navBar.classList.toggle("open");
  navBar.classList.toggle("close");
});

menuLatBtn.addEventListener("click", () => {
  menuLat.classList.toggle("lat_open");
  menuLat.classList.toggle("lat_close");
  arrowLat.classList.toggle("arrow_lat");
  container.classList.toggle("con_open");
  container.classList.toggle("con_close");
});
