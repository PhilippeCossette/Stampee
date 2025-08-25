{{ include("layouts/header.php", { title: "Details Enchere - Stampee" }) }}
{% if success is defined and success %}
<div class="success-msg">
  <i class="fa fa-check"></i>
  {{ success }}
</div>
{% endif %}
<section class="auction-card">
  <div class="auction-card_left-section">
    {% if auction.certifie == 1 %}
    <img class="auction-card-certified" src="{{asset}}img/certified.png" alt="">
    {% endif %}
    <script>
      const images = {{(images is defined ? images : []) | json_encode | raw}};
    </script>
    <div class="image-slider">
      <picture>
        <img id="slider-img" data-zoom="true" src="" alt="Image du timbre">
      </picture>
      <div class="button-container">
        <button id="prev-btn"><img src="{{asset}}img/next-button.png" alt="" style="transform: rotateY(180deg);"></button>
        <button id="next-btn"><img src="{{asset}}img/next-button.png" alt=""></button>
      </div>
    </div>
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
        Vendu Par – {{ auction.proprietaire_nom }}
      </p>
      <h2 class="auction-card_action-price">{{ auction.prix_actuel }} $</h2>
      <p class="auction-card_action-info">Offre actuelle</p>
      <p class="auction-card_action-info">
        <span class="timer" data-fin="{{ auction.fin }}"></span>
      </p>
      <p class="auction-card_action-info">Créé en {{ auction.annee }}</p>
      <p class="auction-card_action-info">Pays d'origine : {{ auction.pays }}</p>
      <p class="auction-card_action-info">État : {{ auction.condition }}</p>
      <p class="auction-card_action-info">Couleur : {{ auction.couleur }}</p>
      <p class="auction-card_action-info">Dimensions : {{ auction.dimension }} mm</p>
      <p class="auction-card_action-info">Description : {{ auction.description }}</p>
      {% if auction.id_proprietaire == session.user_id %}
      <div class="button main-button" onclick="window.location.href='{{ base }}/stamp/update?id={{ auction.timbre_id }}'">Modifier l'enchère</div>
      {% elseif auction.status == 0 %}
      <div class="button inactive-button">Archivée</div>
      {% else %}
      <div class="button main-button" onclick="window.location.href='{{ base }}/bid?id_enchere={{ auction.enchere_id }}'">Enchérir</div>
      {% endif %}
      <div class="button secondary-button">Voir toutes les offres</div>
      <button class="fav-btn button {{ auction.isFavori ? 'favorited' : '' }}" data-id="{{ auction.enchere_id }}">
        {{ auction.isFavori ? 'Favori ajouté' : 'Ajouter aux favoris' }}
      </button>
      <p class="auction-card_action-info">
        {% if auction.favoris_count > 1 %}
        {{ auction.favoris_count }} personnes suivent cette enchère.
        {% else %}
        {{ auction.favoris_count }} personne suit cette enchère.
        {% endif %}
      </p>
    </div>
  </div>
</section>
{{ include("layouts/footer.php") }}