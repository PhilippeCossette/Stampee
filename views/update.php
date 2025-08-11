{{ include('layouts/header.php', {title:'Modifer Profile - Stampee'})}}


<form class="form" action="{{base}}/user/update" method="post">
<input type="text" name="nom_utilisateur" id="nom_utilisateur" value="{{ inputs.nom_utilisateur }}" class="form-input" required>
<input type="email" name="email" id="email" value="{{ inputs.email}}" class="form-input" required>
<input type="password" name="mot_de_passe" id="mot_de_passe" value="{{ inputs.mot_de_passe }}" class="form-input" required>

</form>







{{ include('layouts/footer.php')}}