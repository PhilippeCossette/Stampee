export function initZoomImages() {
  const zoomImg = document.querySelector("[data-zoom='true']");
  zoomImg.parentElement.addEventListener("mousemove", (e) => {
    const rect = zoomImg.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const xPercent = (x / rect.width) * 100;
    const yPercent = (y / rect.height) * 100;

    zoomImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
    zoomImg.style.transform = "scale(2)";
  });

  zoomImg.parentElement.addEventListener("mouseleave", () => {
    zoomImg.style.transform = "scale(1)";
    zoomImg.style.transformOrigin = "center";
  });
}
