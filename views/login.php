{{ include('layouts/header.php', {title:'Page de connexion - Stampee'})}}
<div class="wrapper-centered">
<form class="login-form" action="{{base}}/login" method="post">
  <header class="login-form-header">
  <p>Entrez vos informations</p>
  <h1>Bon retour !</h1>
</header>
  <div>
  <input type="text" id="nom_utilisateur" aria-label="Nom d'utilisateur" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
  {% if errors.nom_utilisateur is defined %}                   
    <span class="error">{{ errors.nom_utilisateur }}</span>
  {% endif %}
  </div>

  <div>
    <input type="password" id="mot_de_passe" aria-label="Mot de passe" name="mot_de_passe" placeholder="Mot de Passe" required>
    {% if errors.mot_de_passe is defined %}
      <span class="error">{{ errors.mot_de_passe }}</span>
    {% endif %}
  </div>
    {% if errors.message is defined %}
    <span class="error">{{ errors.message }}</span>
    {% endif %}
   <button type="submit">Se Connecter</button>
</form>
</div>


{{ include('layouts/footer.php')}}