{{ include("layouts/header.php", { title: "Page du Profile - Stampee" }) }}

<h1>Liste des enchères</h1>

{% for enchere in encheres %}
<div class="enchere-card">
    <h2>{{ enchere.titre }}</h2>
    <img src="{{asset}}uploads/{{ enchere.image_principale }}" alt="{{ enchere.titre }}">
    <p><strong>Prix départ :</strong> {{ enchere.prix_actuel }} $</p>
    <p>Temps restant : <span class="timer" data-fin="{{ enchere.fin }}"></span></p>
</div>
{% endfor %}

{{ include("layouts/footer.php") }}