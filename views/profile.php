{{ include('layouts/header.php', {title:'Page du Profile - Stampee'})}}

<!-- {% for item in session %}
  {{ item }}
{% endfor %} -->
<section class="profile">
    <header class="profile-header">
        <h1>Details du Compte</h1>
            {% if error is defined %}
        <span class="error" role="alert">
            {{ error }}
        </span>
        {% endif %}
        <div class="profile-details">
            <img src="{{asset}}/img/user.png" alt="">
            <div>
                <p><strong>Nom:</strong> {{ session.nom_utilisateur }}</p>
                <p><strong>Email:</strong> {{ session.email }}</p>
            </div>
            <div>
                <a class="button secondary-button" href="{{base}}/user/update">Modifier Compte</a>
                <a class="button red-button" id="delete-btn">Supprimer Compte</a>
            </div>
        </div>
    </header>
    <article class="my-auctions">

</article>
<article class="favorite-auctions">

</article>
<article class="offer-history">

</article>

</section>

{{ include('layouts/footer.php')}}


<!-- Historique D'offre enchere favorites -->