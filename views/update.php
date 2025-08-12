{{ include("layouts/header.php", { title: "Modifer Profile - Stampee" }) }}

<div class="wrapper-centered">
  <form class="form" action="{{ base }}/user/update" method="post">
    <header class="form-header">
      <p class="form-header-undertitle">Changez vos informations</p>
      <h1 class="form-header-title">Modifier mon profil</h1>
    </header>
    <div></div>
    <div>
      <input
        type="text"
        name="nom_utilisateur"
        id="nom_utilisateur"
        value="{{ inputs.nom_utilisateur }}"
        class="form-input"
        required
      />
      {% if errors.nom_utilisateur is defined %}
      <span class="error">{{ errors.nom_utilisateur }}</span>
      {% endif %}
    </div>
    <div>
      <input
        type="email"
        name="email"
        id="email"
        value="{{ inputs.email }}"
        class="form-input"
        required
      />
      {% if errors.email is defined %}
      <span class="error">{{ errors.email }}</span>
      {% endif %}
    </div>
    <div>
      <input
        type="password"
        name="mot_de_passe"
        id="mot_de_passe"
        value=""
        class="form-input"
        placeholder="Mot de Passe"
      />
      {% if errors.mot_de_passe is defined %}
      <span class="error">{{ errors.mot_de_passe }}</span>
      {% endif %}
    </div>
    <button class="main-button" type="submit">Mettre a jour</button>
  </form>
</div>

{{ include("layouts/footer.php") }}
