import initNav from "./script/nav.js";
import { initConfirm } from "./script/confirm-delete.js";

document.addEventListener("DOMContentLoaded", () => {
  initConfirm("delete-btn", "/user/delete");
});

initNav();
