export function deleteImg() {
  const deletebtn = document.querySelectorAll(".delete-button");
  deletebtn.forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      const imgContainer = e.target.closest(".img-container");
      const imageId = imgContainer.dataset.id;
      if (!confirm("Are you sure you want to delete this image?")) {
        return;
      }

      try {
        const response = fetch("/Stampee/stamp/deleteImage", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({ id: imageId }),
        });

        const result = await response.json();

        if (result.success) {
          imgContainer.remove();
        } else {
          alert("Erreur lors de la suppression de l'image");
        }
      } catch (error) {
        console.error("Error:", error);
        alert("Une erreur s'est produite lors de la suppression de l'image");   
      }
    });
  });
}
