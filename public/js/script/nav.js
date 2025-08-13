let dropdowns = document.querySelectorAll("[data-dropdown='true']");
let dropdownContainers = document.querySelectorAll(".desktop-dropdown");
const hamburgerMenu = document.querySelector(".nav-mobile_menu");
const mobileMenu = document.getElementById("mobile-menu");
const closeMenu = document.getElementById("close-menu");

function openDropdown(container) {
  container.classList.remove("hideContent");
}

function closeDropdown(container) {
  container.classList.add("hideContent");
}

function initNav() {
  dropdowns.forEach((dropdown, index) => {
    const container = dropdownContainers[index];

    dropdown.addEventListener("mouseenter", () => openDropdown(container));
    container.addEventListener("mouseleave", () => closeDropdown(container));
  });

  hamburgerMenu.addEventListener("click", function () {
    mobileMenu.classList.toggle("active");
  });

  closeMenu.addEventListener("click", function () {
    mobileMenu.classList.remove("active");
  });
}

export default initNav;
