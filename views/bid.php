{{ include("layouts/header.php", { title: "Page de connexion - Stampee" }) }}
<div class="wrapper-centered">
    <form class="form" method="POST" action="{{ base }}/bid/store">
        <header class="form-header">
            <p class="form-header-undertitle">Faites une mise</p>
            <h1 class="form-header-title">Misez !</h1>
        </header>
        <p class="form-header-undertitle">Prix actuel : {{ auction.prix_actuel }}</p>

        <input type="hidden" name="id_enchere" value="{{ auction.enchere_id }}">
        <input class="form-input" type="number" name="montant" placeholder="Entrez votre offre">
        {% if errors.montant is defined %}
        <p class="error">{{ errors.montant }}</p>
        {% endif %}
        <button class="button main-button" type="submit">Enchérir</button>
    </form>
</div>
{{ include("layouts/footer.php") }}