{{ include("layouts/header.php", { title: "Liste Enchere - Stampee" }) }}


<section class="auction-list">
    <h1 class="auction-list-title">Liste des enchères</h1>
    <div class="filter-options">
        <button class="filter-button-open"><img src="{{ asset }}img/filter.png" alt="filter icon"></button>
        <form method="GET" action="{{ base }}/auctionlist" class="filter-options-form hideContent">
            <button class="filter-button-close">&times;</button>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ filters.search }}">
            <select class="form-input" name="color">
                <option value="">Toutes les couleurs</option>
                {% for color in filterOptions.colors %}
                <option value="{{ color.id_couleur }}" {% if filters.color == color.id_couleur %}selected{% endif %}>{{ color.couleur }}</option>
                {% endfor %}
            </select>
            <select class="form-input" name="pays">
                <option value="">Toutes les pays</option>
                {% for pays in filterOptions.pays %}
                <option value="{{ pays.id_pays }}" {% if filters.pays == pays.id_pays %}selected{% endif %}>{{ pays.pays }}</option>
                {% endfor %}
            </select>
            <select class="form-input" name="status">
                <option value="1" {% if filters.status == 1 %}selected{% endif %}>Actives</option>
                <option value="0" {% if filters.status == 0 %}selected{% endif %}>Archivées</option>
                <option value="" {% if filters.status is empty %}selected{% endif %}>Toutes</option>
            </select>
            <select class="form-input" name="condition">
                <option value="">Toutes les conditions</option>
                {% for cond in filterOptions.conditions %}
                <option value="{{ cond.id_condition }}" {% if filters.condition == cond.id_condition %}selected{% endif %}>{{ cond.condition }}</option>
                {% endfor %}
            </select>
            <select class="form-input" name="year">
                <option value="">Toutes les années</option>
                {% for year in filterOptions.years %}
                <option value="{{ year }}" {% if filters.year == year %}selected{% endif %}>{{ year }}</option>
                {% endfor %}
            </select>
            <div class="checkbox">
                <label for="certified">Certifié</label>
                <input type="checkbox" id="certified" name="certified" value="1" {% if filters.certified %}checked{% endif %}>
            </div>
            <div class="checkbox">
                <label for="coup_coeur">CDC du Lord</label>
                <input type="checkbox" id="coup_coeur" name="coup_coeur" value="1" {% if filters.coup_coeur %}checked{% endif %}>
            </div>
            <button type="submit" class="button main-button">Filtrer</button>
        </form>
    </div>
    <div class="auction-list-grid grid">
        {% for enchere in encheres %}
        <a href="{{base}}/auction?id={{enchere.enchere_id}}" class="auctionShowcase-card">
            <header class="auctionShowcase-card-header">
                {% if enchere.coup_coeur == 1 %}
                <small class="auctionShowcase-card-header-undertitle">Coups de Coeur</small>
                {% endif %}
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
            {% if enchere.status == 0 %}
            <p><span class="red-text">Terminé</span></p>
            <button class="button inactive-button" onclick="window.location.href='{{ base }}/auction?id={{ enchere.enchere_id }}'">Archivées</button>
            {% else %}
            <p><span class="timer" data-fin="{{ enchere.fin }}"></span></p>
            <button class="button main-button" onclick="window.location.href='{{ base }}/auction?id={{ enchere.enchere_id }}'">Misez</button>
            {% endif %}
        </a>
        {% endfor %}
    </div>
</section>



{{ include("layouts/footer.php") }}