<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Découvrez des timbres rares et de collection dans nos enchères en ligne. Achetez, vendez et enchérissez facilement sur des timbres uniques."
    />
    <title>Fiche Enchere</title>
    <link rel="stylesheet" href="./assets/css/main.css" />
    <script src="assets/script/main.js" defer></script>
  </head>
  <body>
    <header>
      <nav class="nav-desktop">
        <div class="nav-desktop__main">
          <a href="#" class="nav-desktop_logo"
            ><img src="assets/img/logo.webp" alt="logo stampee"
          /></a>
          <a href="#" class="nav-link">Devenir membre</a>
          <a href="#" class="nav-link">Actualité</a>
          <a href="#" class="nav-link" data-dropdown="true"
            >Enchères
            <img src="assets/img/down-arrow.webp" alt="menu deroulant icone"
          /></a>
          <div class="desktop-dropdown hideContent">
            <a href="#" class="nav-link">Explorer les enchères</a>
            <a href="#" class="nav-link">Catégories</a>
            <a href="#" class="nav-link">Mes enchères</a>
            <a href="#" class="nav-link">Ajouter une enchère</a>
            <a href="#" class="nav-link">Offres récentes</a>
          </div>
          <a href="#" class="nav-link"><strong>Se connecter</strong></a>
        </div>
        <div class="nav-desktop__secondary">
          <a href="#" class="nav-link">À propos de Lord Reginald Stampee III</a>
          <a href="#" class="nav-link">Langues</a>
          <form action="POST" class="search">
            <input
              type="text"
              aria-label="search"
              class="search_bar"
              name="search"
              value="Recherche..."
            />
            <button class="search_button">
              <img src="./assets/img/search.webp" alt="search icon" />
            </button>
          </form>
        </div>
      </nav>
      <nav class="nav-mobile">
        <a href="#" class="nav-mobile_logo"
          ><img src="assets/img/logo.webp" alt="logo stampee"
        /></a>
        <a href="#" class="nav-mobile_menu"
          ><img src="assets/img/hamburger.webp" alt="hamburger"
        /></a>
      </nav>
      <div class="nav-mobile-menu" id="mobile-menu">
        <button id="close-menu" class="close-btn">&times;</button>
        <a href="#" class="nav-link">Enchères</a>
        <a href="#" class="nav-link">Devenir membre</a>
        <a href="#" class="nav-link">Actualité</a>
        <a href="#" class="nav-link">À propos de Lord Reginald Stampee III</a>
        <a href="#" class="nav-link">Langues</a>
        <a href="#" class="nav-link"><strong>Se connecter</strong></a>
      </div>
    </header>
    <main>
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
            alt="lot de timbres"
          />
        </div>
        <div class="auction-card_right-section">
          <div class="auction-card_header">
            <h1 class="auction-card_header-title">
              Lot de timbres vintage des États-Unis
            </h1>
            <small class="auction-card_header-small">Timbres anciens</small>
          </div>
          <div class="auction-card_action">
            <p class="auction-card_action-info">
              Informations sur le vendeur – Jean-Pierre (A+)
            </p>
            <h2 class="auction-card_action-price">193$</h2>
            <p class="auction-card_action-info">Offre actuelle</p>
            <p class="auction-card_action-info">Créé en 1988</p>
            <p class="auction-card_action-info">Pays d'origine : États-Unis</p>
            <p class="auction-card_action-info">État : Parfait</p>
            <p class="auction-card_action-info">Couleur(s) : Bleu</p>
            <p class="auction-card_action-info">Tirage : 10</p>
            <p class="auction-card_action-info">Dimensions : 50 cm x 45 cm</p>
            <p class="auction-card_action-info">Certifié : Oui</p>
            <div class="button main-button">Enchérir</div>
            <div class="button secondary-button">Voir toutes les offres</div>
            <div class="button secondary-button">En savoir plus</div>
            <div class="button secondary-button">Ajouter aux Favoris</div>
            <p class="auction-card_action-info">
              Enchère populaire. 15 personnes suivent cette enchère.
            </p>
          </div>
        </div>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-column-logo">
        <img
          src="assets/img/logo.webp"
          alt="logo-stampee"
          class="footer-logo"
        />
        <p class="footer-copyright">Copyright &copy; 2024</p>
      </div>
      <div class="footer-column">
        <h3 class="footer-section">Notre Platforme</h3>
        <a href="#" class="footer-link">Profile</a>
        <a href="#" class="footer-link">Comment placer une offre</a>
        <a href="#" class="footer-link">Suivre une enchère</a>
        <a href="#" class="footer-link">Trouver une enchère</a>
      </div>
      <div class="footer-column">
        <h3 class="footer-section">Contactez-nous</h3>
        <a href="#" class="footer-link">Angleterre</a>
        <a href="#" class="footer-link">Canada</a>
        <a href="#" class="footer-link">États-Unis</a>
        <a href="#" class="footer-link">Australie</a>
      </div>
      <div class="footer-column">
        <h3 class="footer-section">Termes et conditions</h3>
        <a href="#" class="footer-link">Sécurité</a>
        <a href="#" class="footer-link">Ne pas vendre mes informations</a>
        <a href="#" class="footer-link">Plus d'informations...</a>
      </div>
    </footer>
  </body>
</html>
