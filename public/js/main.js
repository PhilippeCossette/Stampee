import initNav from "./script/nav.js";
import { initConfirm } from "./script/confirm-delete.js";
import { updateTimers } from "./script/timer.js";

document.addEventListener("DOMContentLoaded", () => {
  initConfirm("delete-btn", "/Stampee/user/delete");
  initNav();

  updateTimers();
  setInterval(updateTimers, 1000);
});
