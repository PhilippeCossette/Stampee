import initNav from "./script/nav.js";
import { initConfirm } from "./script/confirm-delete.js";
import { updateTimers } from "./script/timer.js";
import { filterMenu } from "./script/filter-menu.js";

document.addEventListener("DOMContentLoaded", () => {
  initConfirm("delete-btn", "/Stampee/user/delete");
  initNav();
  filterMenu();

  updateTimers();
  setInterval(updateTimers, 1000);
});
