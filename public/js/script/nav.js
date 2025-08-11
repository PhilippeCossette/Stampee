let dropdown = document.querySelector("[data-dropdown='true']");
let dropdownContainer = document.querySelector(".desktop-dropdown");
const hamburgerMenu = document.querySelector(".nav-mobile_menu");
const mobileMenu = document.getElementById("mobile-menu");
const closeMenu = document.getElementById("close-menu");

function openDropdown() {
  dropdownContainer.classList.remove("hideContent");
}

function closeDropdown() {
  dropdownContainer.classList.add("hideContent");
}

function initNav() {
  dropdown.addEventListener("mouseenter", openDropdown);
  dropdownContainer.addEventListener("mouseleave", closeDropdown);

  hamburgerMenu.addEventListener("click", function () {
    mobileMenu.classList.toggle("active");
  });

  closeMenu.addEventListener("click", function () {
    mobileMenu.classList.remove("active");
  });
}

export default initNav;