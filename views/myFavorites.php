{{ include("layouts/header.php", { title: "Mes favoris - Stampee" }) }}
<section class="max-1200">
    <article class="profile-section">
        <header class="profile-section-header">
            <h2 class="profile-section-header-title">Mes enchères favorites</h2>
            <a class="profile-section-header-link" href="{{ base }}/profile">Mon Profile <i class="fa-solid fa-angle-right"></i></a>
        </header>
        <div class="grid">
            {% if favoris is not empty %}
            {% for favoris in favoris %}
            <a href="{{base}}/auction?id={{favoris.enchere_id}}" class="auctionShowcase-card">
                <header class="auctionShowcase-card-header">
                    {% if favoris.coup_coeur == 1 %}
                    <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
                    {% endif %}
                    <h2 class="auctionShowcase-card-header-title" title="{{ favoris.titre }}">{{ favoris.titre|slice(0, 20) ~ (favoris.titre|length > 20 ? '…' : '') }}</h2>
                    <small class="auctionShowcase-card-small">{{ favoris.condition_nom }}</small>
                    {% if favoris.certifie == 1 %}
                    <img class="auctionShowcase-card-certified" src="{{asset}}img/certified.png" alt="">
                    {% endif %}
                </header>
                <picture class="auctionShowcase-card-imgContainer"><img
                        class="auctionShowcase-card-img"
                        src="{{asset}}uploads/{{ favoris.image_principale }}"
                        alt="Image of an auction card displaying stamps" /></picture>
                <p>{{ favoris.prix_actuel }} $</p>
                <p>
                    <span class="timer" data-fin="{{ favoris.fin }}"></span>
                </p>
            </a>
            {% endfor %}
            {% else %}
            <p class="empty-message">Aucune enchère favorite trouvée.</p>
            {% endif %}
        </div>
    </article>
</section>









{{ include("layouts/footer.php") }}