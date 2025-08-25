import initNav from "./script/nav.js";
import { initConfirm } from "./script/confirm-delete.js";
import { updateTimers } from "./script/timer.js";
import { filterMenu } from "./script/filter-menu.js";
import { imageSlider } from "./script/image-slider.js";
import { initFavorites } from "./script/favorite.js";

document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("delete-btn")) {
    initConfirm("delete-btn", "/Stampee/user/delete");
  }
  initNav();
  filterMenu();
  initFavorites();

  if (typeof images !== "undefined") {
    imageSlider(images);
  }

  updateTimers();
  setInterval(updateTimers, 1000);
});
