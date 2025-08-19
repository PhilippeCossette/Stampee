<h1>Liste des enchères</h1>

{% for enchere in encheres %}
<div class="enchere-card">
    <h2>{{ enchere.titre }}</h2>
    <img src="{{asset}}uploads/{{ enchere.image_principale }}" alt="{{ enchere.titre }}">
    <p><strong>Prix départ :</strong> {{ enchere.prix_depart }} $</p>
    <p><strong>Début :</strong> {{ enchere.debut }}</p>
    <p><strong>Fin :</strong> {{ enchere.fin }}</p>
</div>
{% endfor %}