{{ include('layouts/header.php', {title:'Page du Profile - Stampee'})}}

<!-- {% for item in session %}
  {{ item }}
{% endfor %} -->
<section class="profile">
    <header class="profile-header">
        <h1>Details du Compte</h1>
        <div class="profile-details">
            <img src="{{asset}}/img/user.png" alt="">
            <div>
                <p><strong>Nom:</strong> {{ session.username }}</p>
                <p><strong>Email:</strong> {{ session.email }}</p>
            </div>
            <div>
                <a class="button secondary-button" href="">Modifier Compte</a>
                <a class="button red-button" href="">Supprimer Compte</a>
            </div>
        </div>
    </header>
</section>
<section class="favorite-auctions">

</section>
<section class="my-auctions">

</section>
<section class="offer-history">

</section>

{{ include('layouts/footer.php')}}


<!-- Historique D'offre enchere favorites -->