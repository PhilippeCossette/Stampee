export function imageSlider(images) {
  let currentIndex = 0;
  const imgEl = document.getElementById("slider-img");

  function showImage(index) {
    if (!images.length) return;
    imgEl.src = "/stampee/public/uploads/" + images[index].url_image; // adjust path if needed
  }

  // Initial image
  showImage(currentIndex);

  document.getElementById("prev-btn").onclick = function () {
    currentIndex = (currentIndex - 1 + images.length) % images.length; // Go to previous image
    showImage(currentIndex);
  };

  document.getElementById("next-btn").onclick = function () {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
  };
}
