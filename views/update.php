{{ include('layouts/header.php', {title:'Modifer Profile - Stampee'})}}


<form class="form" action="{{base}}/user/update" method="post">
<input type="text" name="nom_utilisateur" id="nom_utilisateur" value="{{ inputs.nom_utilisateur }}" class="form-input" required>
{% if errors.nom_utilisateur is defined %}
      <span class="error">{{ errors.nom_utilisateur }}</span>
    {% endif %}
<input type="email" name="email" id="email" value="{{ inputs.email}}" class="form-input" required>
{% if errors.email is defined %}
      <span class="error">{{ errors.email }}</span>
    {% endif %}
<input type="password" name="mot_de_passe" id="mot_de_passe" value="" class="form-input" placeholder="Mot de Passe">
{% if errors.mot_de_passe is defined %}
      <span class="error">{{ errors.mot_de_passe }}</span>
    {% endif %}
<button type='submit'>Mettre a jour</button>
</form>







{{ include('layouts/footer.php')}}