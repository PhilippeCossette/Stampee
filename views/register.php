{{ include("layouts/header.php", { title: "Page d'inscription - Stampee" }) }}
<div class="wrapper-centered">
  <form class="form" action="{{ base }}/register" method="post">
    <header class="form-header">
      <p class="form-header-undertitle">Entrez vos informations</p>
      <h1 class="form-header-title">Créez votre compte</h1>
    </header>
    <div>
      <input
        class="form-input"
        type="text"
        id="nom_utilisateur"
        name="nom_utilisateur"
        placeholder="Nom d'utilisateur"
        required
      />
      {% if errors.nom_utilisateur is defined %}
      <span class="error">{{ errors.nom_utilisateur }}</span>
      {% endif %}
    </div>
    <div>
      <input
        class="form-input"
        type="email"
        id="email"
        name="email"
        placeholder="Adresse Email"
        required
      />
      {% if errors.email is defined %}
      <span class="error">{{ errors.email }}</span>
      {% endif %}
    </div>
    <div>
      <input
        class="form-input"
        type="password"
        id="mot_de_passe"
        name="mot_de_passe"
        placeholder="Mot de Passe"
        required
      />
      {% if errors.mot_de_passe is defined %}
      <span class="error">{{ errors.mot_de_passe }}</span>
      {% endif %}
    </div>

    <button class="main-button" type="submit">S'inscrire</button>
  </form>
</div>

{{ include("layouts/footer.php") }}
