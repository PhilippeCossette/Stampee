{{ include("layouts/header.php", { title: "Page du Profile - Stampee" }) }}

<h1>Liste des enchères</h1>

<section class="auction-list">
    <div class="filter-options">
    </div>
    <div class="auction-grid">
        {% for enchere in encheres %}
        <a href="{{base}}/auction?id={{enchere.enchere_id}}" class="enchere-card">
            <h2>{{ enchere.titre }}</h2>
            <img src="{{asset}}uploads/{{ enchere.image_principale }}" alt="{{ enchere.titre }}">
            <p><strong>Prix départ :</strong> {{ enchere.prix_actuel }} $</p>
            <p>Temps restant : <span class="timer" data-fin="{{ enchere.fin }}"></span></p>
        </a>
        {% endfor %}
    </div>
</section>


{{ include("layouts/footer.php") }}