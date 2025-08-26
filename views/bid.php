{{ include("layouts/header.php", { title: "Misez - Stampee" }) }}
{% if highestBidder %}
<div class="warning-msg">
    <i class="fa fa-warning"></i>
    Vous ne pouvez pas enchérir, vous êtes déjà le plus offrant.
</div>
{% elseif auction.id_proprietaire == session.user_id %}
<div class="warning-msg">
    <i class="fa fa-warning"></i>
    Vous ne pouvez pas enchérir sur votre propre enchère.
</div>
{% endif %}
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
        {% if highestBidder or auction.id_proprietaire == session.user_id %}
        <button class="button inactive-button" disabled type="submit">Enchérir</button>
        {% else %}
        <button class="button main-button" type="submit">Enchérir</button>
        {% endif %}
    </form>
</div>
{{ include("layouts/footer.php") }}