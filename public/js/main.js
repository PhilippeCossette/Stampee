import initNav from "./script/nav.js";
import { initConfirm } from "./script/confirm-delete.js";
import { updateTimers } from "./script/timer.js";
import { filterMenu } from "./script/filter-menu.js";
import { imageSlider } from "./script/image-slider.js";

document.addEventListener("DOMContentLoaded", () => {
  initConfirm("delete-btn", "/Stampee/user/delete");
  initNav();
  filterMenu();
  imageSlider(images);

  updateTimers();
  setInterval(updateTimers, 1000);
});
