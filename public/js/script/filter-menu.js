export function filterMenu() {
  const openBtn = document.querySelector(".filter-button-open");
  const closeBtn = document.querySelector(".filter-button-close");
  const filterMenu = document.querySelector(".filter-options-form");

  if (!openBtn || !closeBtn || !filterMenu) return;
  console.log(openBtn, closeBtn, filterMenu);
  openBtn.addEventListener("click", () => {
    filterMenu.classList.toggle("hideContent");
  });

  closeBtn.addEventListener("click", () => {
    filterMenu.classList.toggle("hideContent");
  });
}
