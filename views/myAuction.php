{{ include("layouts/header.php", { title: "Mes Encheres - Stampee" }) }}
<section class="max-1200 inlineP-huge">
    <article class="profile-section">
        <header class="profile-section-header">
            <h2 class="profile-section-header-title">Mes enchères</h2>
            <a class="profile-section-header-link" href="{{ base }}/profile">Mon Profile <i class="fa-solid fa-angle-right"></i></a>
        </header>
        <div class="grid">
            {% if mesEncheres is not empty %}
            {% for mesEnchere in mesEncheres %}
            <a href="{{base}}/auction?id={{mesEnchere.enchere_id}}" class="auctionShowcase-card">
                <header class="auctionShowcase-card-header">
                    {% if mesEnchere.coup_coeur == 1 %}
                    <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
                    {% endif %}
                    <h2 class="auctionShowcase-card-header-title" title="{{ mesEnchere.titre }}">{{ mesEnchere.titre|slice(0, 20) ~ (mesEnchere.titre|length > 20 ? '…' : '') }}</h2>
                    <small class="auctionShowcase-card-small">{{ mesEnchere.condition_nom }}</small>
                    {% if mesEnchere.certifie == 1 %}
                    <img class="auctionShowcase-card-certified" src="{{asset}}img/certified.png" alt="">
                    {% endif %}
                </header>
                <picture class="auctionShowcase-card-imgContainer"><img
                        class="auctionShowcase-card-img"
                        src="{{asset}}uploads/{{ mesEnchere.image_principale }}"
                        alt="Image of an auction card displaying stamps" /></picture>
                <p>{{ mesEnchere.prix_actuel }} $</p>
                <p>
                    <span class="timer" data-fin="{{ mesEnchere.fin }}"></span>
                </p>
            </a>
            {% endfor %}
            {% else %}
            <p class="empty-message">Aucune enchère trouvée.</p>
            {% endif %}
        </div>
    </article>
</section>
{{ include("layouts/footer.php") }}