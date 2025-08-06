let dropdown = document.querySelector("[data-dropdown='true']");
let dropdownContainer = document.querySelector(".desktop-dropdown")
const hamburgerMenu = document.querySelector(".nav-mobile_menu")
const mobileMenu = document.getElementById('mobile-menu');
const closeMenu = document.getElementById('close-menu');


function init(){
    dropdown.addEventListener("mouseenter", openDropdown);;
    dropdownContainer.addEventListener("mouseleave", closeDropdown);

    hamburgerMenu.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
    });

    closeMenu.addEventListener('click', function() {
        mobileMenu.classList.remove('active');
    });
}

function openDropdown(){
    dropdownContainer.classList.remove("hideContent");
    
}

function closeDropdown() {
    dropdownContainer.classList.add("hideContent");
}
init()


