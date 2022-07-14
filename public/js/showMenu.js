// Afficher le menu si la largeur d'écran est inférieure à 1100px
let menuContainer = document.querySelector(".menu-container");
const body = document.querySelector("body");
function showMenu() {
  if (menuContainer.style.visibility === "hidden") {
    menuContainer.style.visibility = "visible";
    menuContainer.style.opacity = "1";
    body.style.overflow = "hidden";
  } else {
    menuContainer.style.visibility = "hidden";
    menuContainer.style.opacity = "0";
    body.style.overflow = "auto";
  }
  // menuContainer.style.visibility = "visible";
}

if (window.innerWidth > 1100) {
  menuContainer.style.visibility = "hidden";
  menuContainer.style.opacity = "0";
  body.style.overflow = "auto";
}

// if (menuContainer.style.visibility === "visible") {
//   if (window.innerWidth > 1100) {
//     menuContainer.style.visibility = "hidden";
//   }
//   body.addEventListener("keydown", event => {
//     if (event.keyCode === 27) {
//       menuContainer.style.visibility = "hidden";
//       menuContainer.style.opacity = "0";
//       body.style.overflow = "auto";
//     }
//     // showMenu();
//   });
// }