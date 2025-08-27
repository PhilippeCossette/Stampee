export function updateTimers() {
  const timers = document.querySelectorAll(".timer");
  timers.forEach((timer) => {
    const fin = new Date(timer.dataset.fin).getTime();
    const now = new Date().getTime();
    const diff = fin - now;

    if (diff <= 0) {
      timer.textContent = "Terminé";
      timer.classList.add("red-text");
    } else {
      // Update timer text
      const hours = Math.floor(diff / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);
      timer.textContent = `${hours}h ${minutes}m ${seconds}s`;
    }
  });
}
