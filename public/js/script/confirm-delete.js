export function initConfirm(buttonId, redirectUrl) {
  const button = document.getElementById(buttonId);
  if (!button) {
    console.error(`Button with ID ${buttonId} not found.`);
    return;
  }

  button.addEventListener("click", () => {
    const confirmation = confirm(
      "Are you sure you want to delete your account?"
    );

    if (confirmation) {
      window.location.href = redirectUrl; // Redirects to the delete action
    }
  });
}
