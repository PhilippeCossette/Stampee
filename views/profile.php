{{ include("layouts/header.php", { title: "Page du Profile - Stampee" }) }}

<section class="profile">
  <header class="profile-header">
    <h1>Details du Compte</h1>
    {% if error is defined %}
    <span class="error" role="alert">
      {{ error }}
    </span>
    {% endif %}
    <div class="profile-details">
      <img src="{{ asset }}/img/user.png" alt="" />
      <div>
        <p><strong>Nom:</strong> {{ session.nom_utilisateur }}</p>
        <p><strong>Email:</strong> {{ session.email }}</p>
      </div>
      <div>
        <a class="button secondary-button" href="{{ base }}/user/update">Modifier Compte</a>
        <a class="button red-button" id="delete-btn">Supprimer Compte</a>
      </div>
    </div>
  </header>
  <article class="profile-section">
    <header class="profile-section-header">
      <h2 class="profile-section-header-title">Mes enchères</h2>
      <a class="profile-section-header-link" href="{{ base }}/profile/myAuction">Voir Tout <i class="fa-solid fa-angle-right"></i></a>
    </header>
    <div class="grid">
      {% if mesEncheres is not empty %}
      {% for mesEnchere in mesEncheres %}
      <a href="{{base}}/auction?id={{mesEnchere.enchere_id}}" class="auctionShowcase-card">
        <header class="auctionShowcase-card-header">
          {% if mesEnchere.coup_coeur == 1 %}
          <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
          {% endif %}
          <h2 class="auctionShowcase-card-header-title" title="{{ mesEnchere.titre }}">{{ mesEnchere.titre|slice(0, 20) ~ (mesEnchere.titre|length > 20 ? '…' : '') }}</h2>
          <small class="auctionShowcase-card-small">{{ mesEnchere.condition_nom }}</small>
          {% if mesEnchere.certifie == 1 %}
          <img class="auctionShowcase-card-certified" src="{{asset}}img/certified.png" alt="">
          {% endif %}
        </header>
        <picture class="auctionShowcase-card-imgContainer"><img
            class="auctionShowcase-card-img"
            src="{{asset}}uploads/{{ mesEnchere.image_principale }}"
            alt="Image of an auction card displaying stamps" /></picture>
        <p>{{ mesEnchere.prix_actuel }} $</p>
        <p>
          <span class="timer" data-fin="{{ mesEnchere.fin }}"></span>
        </p>
      </a>
      {% endfor %}
      {% else %}
      <p class="empty-message">Aucune enchère favorite trouvée.</p>
      {% endif %}
    </div>
  </article>



  <article class="profile-section">
    <header class="profile-section-header">
      <h2 class="profile-section-header-title">Mes enchères favorites</h2>
      <a class="profile-section-header-link" href="{{ base }}/profile/favorites">Voir Tout <i class="fa-solid fa-angle-right"></i></a>
    </header>
    <div class="grid">
      {% if favoris is not empty %}
      {% for favoris in favoris %}
      <a href="{{base}}/auction?id={{favoris.enchere_id}}" class="auctionShowcase-card">
        <header class="auctionShowcase-card-header">
          {% if favoris.coup_coeur == 1 %}
          <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
          {% endif %}
          <h2 class="auctionShowcase-card-header-title" title="{{ favoris.titre }}">{{ favoris.titre|slice(0, 20) ~ (favoris.titre|length > 20 ? '…' : '') }}</h2>
          <small class="auctionShowcase-card-small">{{ favoris.condition_nom }}</small>
          {% if favoris.certifie == 1 %}
          <img class="auctionShowcase-card-certified" src="{{asset}}img/certified.png" alt="">
          {% endif %}
        </header>
        <picture class="auctionShowcase-card-imgContainer"><img
            class="auctionShowcase-card-img"
            src="{{asset}}uploads/{{ favoris.image_principale }}"
            alt="Image of an auction card displaying stamps" /></picture>
        <p>{{ favoris.prix_actuel }} $</p>
        <p>
          <span class="timer" data-fin="{{ favoris.fin }}"></span>
        </p>
      </a>
      {% endfor %}
      {% else %}
      <p class="empty-message">Aucune enchère favorite trouvée.</p>
      {% endif %}
    </div>
  </article>
  <article class="offer-history"></article>
</section>

{{ include("layouts/footer.php") }}

<!-- Historique D'offre enchere favorites -->