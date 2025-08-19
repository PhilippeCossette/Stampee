{{ include("layouts/header.php", { title: "Liste Enchere - Stampee" }) }}


<section class="auction-list">
    <h1 class="auction-list-title">Liste des enchères</h1>
    <div class="filter-options">
    </div>
    <div class="auction-list-grid grid">
        {% for enchere in encheres %}
        <a href="{{base}}/auction?id={{enchere.enchere_id}}" class="auctionShowcase-card">
            <header class="auctionShowcase-card-header">
                <h2 class="auctionShowcase-card-header-title" title="{{ enchere.titre }}">{{ enchere.titre|slice(0, 20) ~ (enchere.titre|length > 20 ? '…' : '') }}</h2>
                <small class="auctionShowcase-card-small">{{ enchere.condition_nom }}</small>
                {% if enchere.certifie == 1 %}
                <img class="auctionShowcase-card-certified" src="{{asset}}img/certified.png" alt="">
                {% endif %}
            </header>
            <picture class="auctionShowcase-card-imgContainer"><img
                    class="auctionShowcase-card-img"
                    src="{{asset}}uploads/{{ enchere.image_principale }}"
                    alt="Image of an auction card displaying stamps" /></picture>
            <p>{{ enchere.prix_actuel }} $</p>
            <p><span class="timer" data-fin="{{ enchere.fin }}"></span></p>
            <button class="button main-button" onclick="window.location.href='{{ base }}/auction?id={{ enchere.enchere_id }}'">Misez</button>
        </a>
        {% endfor %}
    </div>
</section>



{{ include("layouts/footer.php") }}