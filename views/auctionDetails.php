{{ include("layouts/header.php", { title: "Details Enchere - Stampee" }) }}
<section class="auction-card">
  <div class="auction-card_left-section">
    <div class="auction-card_img-container">
      <img src="assets/img/stamps-1.webp" alt="photo timbre" />
      <img src="assets/img/stamps-2.webp" alt="photo timbre" />
      <img src="assets/img/stamps-3.webp" alt="photo timbre" />
      <img src="assets/img/stamps-4.webp" alt="photo timbre" />
    </div>
    <img
      src="assets/img/stamps-lot.webp"
      class="auction-card-main-img"
      alt="lot de timbres" />
  </div>
  <div class="auction-card_right-section">
    <div class="auction-card_header">
      <h1 class="auction-card_header-title">
        {{ auction.titre }}
      </h1>
      <small class="auction-card_header-small">Timbres anciens</small>
    </div>
    <div class="auction-card_action">
      <p class="auction-card_action-info">
        Informations sur le vendeur – Jean-Pierre (A+)
      </p>
      <h2 class="auction-card_action-price">{{ auction.prix_actuel }} $</h2>
      <p class="auction-card_action-info">Offre actuelle</p>
      <p class="auction-card_action-info">Créé en {{ auction.annee }}</p>
      <p class="auction-card_action-info">Pays d'origine : {{ auction.pays }}</p>
      <p class="auction-card_action-info">État : {{ auction.condition }}</p>
      <p class="auction-card_action-info">Couleur : {{ auction.couleur }}</p>
      <p class="auction-card_action-info">Dimensions : {{ auction.dimension }} mm</p>
      <p class="auction-card_action-info">Certifié : {{ auction.certifie ? 'Oui' : 'Non' }}</p>
      <p class="auction-card_action-info">Description : {{ auction.description }}</p>
      <div class="button main-button">Enchérir</div>
      <div class="button secondary-button">Voir toutes les offres</div>
      <div class="button secondary-button">Ajouter aux Favoris</div>
      <p class="auction-card_action-info">
        Enchère populaire. 15 personnes suivent cette enchère.
      </p>
    </div>
  </div>
</section>
{{ include("layouts/footer.php") }}