{{ include("layouts/header.php", { title: "Page d'erreur - Stampee" }) }}
<div class="wrapper-centered margin-block flex-column">
    <h1>Erreur</h1>
    <p>{{ message }}</p>
    <a href="{{ base }}/" class="button main-button">Retour à l'accueil</a>
</div>
{{ include("layouts/footer.php") }}