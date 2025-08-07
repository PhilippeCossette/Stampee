<form action="{{base}}/register" method="post">
  <div>
  <label for="nom_utilisateur">Nom d'utilisateur:</label><br>
  <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br>
  {% if errors.nom_utilisateur is defined %}                   
    <span class="error">{{ errors.nom_utilisateur }}</span>
  {% endif %}
  </div>
  <div>
    <label for="email">Adresse courriel:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    {% if errors.email is defined %}
      <span class="error">{{ errors.email }}</span>
    {% endif %}
  </div>
  <div>
    <label for="mot_de_passe">Mot de passe:</label><br>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>
    {% if errors.mot_de_passe is defined %}
      <span class="error">{{ errors.mot_de_passe }}</span>
    {% endif %}
  </div>

  

  <button type="submit">S'inscrire</button>
</form>