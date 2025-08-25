export function initFavorites(){
    const favButtons = document.querySelectorAll('.fav-btn');

    favButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const auctionId = button.dataset.id;
            const action = button.classList.contains('favorited') ? 'remove' : 'add'; // Determine action based on current state

            try {
              const response = await fetch(`/favorites/${action}`, { // path either /favorites/add or /favorites/remove
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({ id_enchere: auctionId }),
              });

              const data = await response.json();

              if (data.success) {
                if (action === "add") {
                  button.textContent = "Favori ajouté";
                  button.classList.add("favorited");
                } else {
                  button.textContent = "Ajouter aux favoris";
                  button.classList.remove("favorited");
                }
              } else {
                alert(
                  data.message || "Erreur lors de la mise à jour des favoris."
                );
              }
            } catch (err) {
              console.error(err);
              alert("Erreur réseau, veuillez réessayer.");
            }
        });
    });
}
