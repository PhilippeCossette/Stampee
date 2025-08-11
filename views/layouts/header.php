<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Découvrez des timbres rares et de collection dans nos enchères en ligne. Achetez, vendez et enchérissez facilement sur des timbres uniques."
    />
    <title>{{ title }}</title>
    <link rel="stylesheet" href="{{asset}}css/main.css" />
    <script src="{{asset}}js/main.js" defer></script>
  </head>
  <body>
    <header>
      <nav class="nav-desktop">
        <div class="nav-desktop__main">
          <a href="#" class="nav-desktop_logo"
            ><img src="{{asset}}/img/logo.webp" alt="logo stampee"
          /></a>
          <div class="desktop-dropdown-wrapper">
  <a href="#" class="nav-link" data-dropdown="true">
    Enchères
    <img src="{{asset}}/img/down-arrow.webp" alt="menu déroulant icône" />
  </a>
  <div class="desktop-dropdown hideContent">
    <a href="#" class="nav-link">Explorer les enchères</a>
    <a href="#" class="nav-link">Catégories</a>
    <a href="#" class="nav-link">Mes enchères</a>
    <a href="#" class="nav-link">Ajouter une enchère</a>
    <a href="#" class="nav-link">Offres récentes</a>
  </div>
</div>
          
          {% if guest %}
          <a href="{{base}}/register" class="nav-link">Devenir membre</a>
           {% else %}
           {% endif %}
          <a href="#" class="nav-link">Actualité</a>
          {% if guest %}
          <a href="{{base}}/login" class="nav-link"><strong>Se connecter</strong></a>
          {% else %}
          <a href="{{base}}/profile" class="nav-link nav-link--profile">
            <small class="nav-link--profile-name">Bonjour, {{ session.username }}</small>
            <p class="nav-link--profile-button">Voir Profile &#8594;</p>  
          </a>
          <a href="{{base}}/logout" class="nav-link-button"><img src="{{asset}}/img/logout.png" alt=""></a>
          {% endif %} 
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
              <img src="{{asset}}/img/search.webp" alt="search icon" />
            </button>
          </form>
        </div>
      </nav>
      <nav class="nav-mobile">
        <a href="#" class="nav-mobile_logo"
          ><img src="{{asset}}/img/logo.webp" alt="logo stampee"
        /></a>
        <a href="#" class="nav-mobile_menu"
          ><img src="{{asset}}/img/hamburger.webp" alt="hamburger"
        /></a>
      </nav>
      <div class="nav-mobile-menu" id="mobile-menu">
        <button id="close-menu" class="close-btn">&times;</button>
        <a href="#" class="nav-link">Enchères</a>
        {% if guest %}
          <a href="{{base}}/register" class="nav-link">Devenir membre</a>
        {% else %}
        {% endif %}
        <a href="#" class="nav-link">Actualité</a>
        <a href="#" class="nav-link">À propos de Lord Reginald Stampee III</a>
        <a href="#" class="nav-link">Langues</a>
        {% if guest %}
          <a href="{{base}}/login" class="nav-link"><strong>Se connecter</strong></a>
          {% else %}
          <a href="#" class="nav-link nav-link--profile">
            <small class="nav-link--profile-name">Bonjour, {{ session.username }}</small>
            <p class="nav-link--profile-button">Voir Profile &#8594;</p>  
          </a>
          <a href="{{base}}/logout" class="nav-link-button"><img src="{{asset}}/img/logout-mobile.png" alt=""></a>
          {% endif %} 
      </div>
    </header>
    <main>