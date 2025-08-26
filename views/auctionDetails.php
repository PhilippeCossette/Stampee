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
      <div class="button secondary-button" onclick="window.location.href='{{ base }}/auction/bids?id={{ auction.enchere_id }}'">Voir toutes les offres</div>
      {% if session.user_id %}
      <button class="fav-btn button {{ auction.isFavori ? 'favorited' : '' }}" data-id="{{ auction.enchere_id }}">
        {{ auction.isFavori ? 'Favori ajouté' : 'Ajouter aux favoris' }}
      </button>
      {% else %}
      <button class="fav-btn button {{ auction.isFavori ? 'favorited' : '' }}" onclick="window.location.href='{{ base }}/login'">
        {{ auction.isFavori ? 'Favori ajouté' : 'Ajouter aux favoris' }}
      </button>
      {% endif %}
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
<section>
  <header class="profile-section-header">
    <h2 class="profile-section-header-title">Mises récentes</h2>
  </header>
  {% if bids is not empty %}
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Utilisateur</th>
          <th>Montant de la mise</th>
          <th>Date de la mise</th>
          <th>Temps restant</th>
          <th>Statut</th>
        </tr>
      </thead>
      <tbody>
        {% for bid in bids %}
        <tr>
          <td>{{ bid.nom_utilisateur }}</td>
          {% if bid.montant >= bid.highest_bid %}
          <td class="green-text">{{ bid.montant }} $</td>
          {% else %}
          <td class="red-text">{{ bid.montant }} $</td>
          {% endif %}
          <td>{{ bid.date_heure|date("d/m/Y H:i") }}</td>
          {% if bid.status == 1 %}
          <td><span class="timer" data-fin="{{ bid.fin }}"></span></td>
          {% else %}
          <td><span class="red-text">Terminé</span></td>
          {% endif %}
          <td>
            {% if bid.status == 1 %}
            <span class="status-indicator active">En cours</span>
            {% elseif bid.status == 0 %}
            {% if bid.is_highest_bidder %}
            <span class="status-indicator won">Gagnée</span>
            {% else %}
            <span class="status-indicator lost">Perdue</span>
            {% endif %}
            {% else %}
            <span class="status-indicator unknown">Inconnu</span>
            {% endif %}
          </td>
        </tr>
        {% endfor %}
      </tbody>
    </table>
  </div>
  {% else %}
  <p class="empty-message">Aucune mise trouvée.</p>
  {% endif %}
</section>
{{ include("layouts/footer.php") }}