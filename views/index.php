{{ include("layouts/header.php", { title: "Page d'accueil - Stampee" }) }}
<main>
  <section
    class="banner noMarginInline"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), #00000080), url('{{
      asset
    }}/img/banner-stamps.webp'); background-size: cover; background-position: center;">
    <h1 class="banner-title">
      Des enchères de timbres sans effort, en un clin d'œil !
    </h1>
    <a href="{{ base }}/auctionlist" class="button main-button">Parcourir Enchere</a>
  </section>
  <section>
    <h2>Notre Mission</h2>
    <p class="biggerParagraph">
      Découvrez une plateforme d'enchères conçue pour tous : simple
      d'utilisation, rapide et efficace. Que vous soyez un collectionneur
      passionné ou un amateur curieux, notre site rend les enchères accessibles
      à toutes les générations. Explorez une vaste collection de timbres rares
      et uniques, faites vos offres en quelques clics, et profitez d'une
      expérience fluide adaptée à vos besoins. Plongez dans l'univers captivant
      de la philatélie, sans stress ni complication.
    </p>
  </section>
  <section class="auctionShowcase max-1200">
    <header class="header-secondary">
      <h2 class="header-secondary-title">Coups de Coeur</h2>
      <a class="button main-button" href="{{base}}/auctionlist?status=&coup_coeur=1">Voir Tout</a>
    </header>
    <div class="popularAuction grid">

      {% for enchere in encheres_CP %}
      <article class="auctionShowcase-card">
        <header class="auctionShowcase-card-header">
          {% if enchere.coup_coeur %}
          <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
          {% endif %}
          <h2 class="auctionShowcase-card-header-title">{{ enchere.titre }}</h2>
        </header>
        <picture class="auctionShowcase-card-imgContainer"><img
            class="auctionShowcase-card-img"
            src="{{asset}}uploads/{{ enchere.url_image }}"
            alt="Image of an auction card displaying stamps" /></picture>
        <button class="button secondary-button" onclick="window.location.href='{{ base }}/auction?id={{ enchere.enchere_id }}'">Plus D'info</button>
      </article>
      {% endfor %}

    </div>
  </section>
  <section class="auctionShowcase max-1200">
    <header class="header-secondary">
      <h2 class="header-secondary-title">Enchères en Cours</h2>
      <a class="button main-button" href="{{ base }}/auctionlist?status=1">Voir Tout</a>
    </header>
    <div class="currentAuction grid">
      {% if encheres is not empty %}
      {% for enchere in encheres %}
      <article class="auctionShowcase-card">
        <header class="auctionShowcase-card-header">
          {% if enchere.coup_coeur %}
          <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
          {% endif %}
          <h2 class="auctionShowcase-card-header-title">{{ enchere.titre }}</h2>
        </header>
        <picture class="auctionShowcase-card-imgContainer"><img
            class="auctionShowcase-card-img"
            src="{{asset}}uploads/{{ enchere.url_image }}"
            alt="Image of an auction card displaying stamps" /></picture>
        <button class="button secondary-button" onclick="window.location.href='{{ base }}/auction?id={{ enchere.enchere_id }}'">Plus D'info</button>
      </article>
      {% endfor %}
      {% else %}
      <p>Aucune enchère en cours trouvée.</p>
      {% endif %}

    </div>
  </section>
  <section class="news grid">
    <div class="title-paragraph-button">
      <h1>Actualités Récentes</h1>
      <p>
        Découvrez l'histoire fascinante du Penny Black, le premier timbre postal
        au monde, mis en vente cette semaine. Une pièce incontournable pour les
        collectionneurs !
      </p>
      <button class="button main-button">Voir toute les actualités</button>
    </div>
    <div class="flex-column flex-column_small-gap">
      <article class="news-card">
        <header class="news-card-header">
          <p><span>Histoire philatélique</span> &#x2022; Novembre 2024</p>
          <h2 class="news-card-header-title">
            Le Penny Black, Premier Timbre Postal En Vente Cette Semaine
          </h2>
        </header>
        <div class="news-card-content">
          <p>
            Découvrez l'histoire fascinante du Penny Black, le premier timbre
            postal au monde, mis en vente cette semaine. Une pièce
            incontournable pour les collectionneurs !
          </p>
          <a href="#"><img src="{{ asset }}/img/right-up.webp" alt="icon redirect" /></a>
        </div>
      </article>
      <article class="news-card">
        <header class="news-card-header">
          <p><span>Résultats des enchères</span> &#x2022; Novembre 2024</p>
          <h2 class="news-card-header-title">
            Collection de Timbres Français Adjugée à Un Montant Record
          </h2>
        </header>
        <div class="news-card-content">
          <p>
            Une collection exceptionnelle de timbres français a été adjugée pour
            un montant record. Retrouvez les détails des enchères et les pièces
            phares de cette collection.
          </p>
          <a href="#"><img src="{{ asset }}/img/right-up.webp" alt="icon redirect" /></a>
        </div>
      </article>
      <article class="news-card">
        <header class="news-card-header">
          <p><span>Tendances contemporaines</span> &#x2022; Novembre 2024</p>
          <h2 class="news-card-header-title">
            Timbres Modernes à L'Honneur Cette Semaine
          </h2>
        </header>
        <div class="news-card-content">
          <p>
            Une sélection unique de timbres modernes aux designs audacieux est à
            l'honneur cette semaine. Ces timbres célèbrent des thèmes actuels,
            allant de l'art aux avancées technologiques.
          </p>
          <a href="#"><img src="{{ asset }}/img/right-up.webp" alt="icon redirect" /></a>
        </div>
      </article>
    </div>
  </section>

  {{ include("layouts/footer.php") }}
</main>