<form action="{{base}}/register" method="post">
  <label for="nom_utilisateur">Nom d'utilisateur:</label><br>
  <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br>

  <label for="email">Adresse courriel:</label><br>
  <input type="email" id="email" name="email" required><br><br>

  <label for="mot_de_passe">Mot de passe:</label><br>
  <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

  <button type="submit">S'inscrire</button>
</form>