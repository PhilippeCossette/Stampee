export function initZoomImages() {
  const zoomImg = document.querySelector("[data-zoom='true']");
  zoomImg.parentElement.addEventListener("mousemove", (e) => {
    // Get mouse position relative to the image
    const rect = zoomImg.getBoundingClientRect();
    // Calculate mouse position
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    // Calculate percentage
    const xPercent = (x / rect.width) * 100;
    const yPercent = (y / rect.height) * 100;

    // Set transform origin and scale
    zoomImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
    zoomImg.style.transform = "scale(2)";
  });

  // Reset zoom on mouse leave
  zoomImg.parentElement.addEventListener("mouseleave", () => {
    zoomImg.style.transform = "scale(1)";
    zoomImg.style.transformOrigin = "center";
  });
}
