<h1>Modifier le Timbre</h1>

{% if timbre is defined %}
<ul>
    <li><strong>ID:</strong> {{ timbre.id }}</li>
    <li><strong>Titre:</strong> {{ timbre.titre }}</li>
    <li><strong>Description:</strong> {{ timbre.description }}</li>
    <li><strong>Année:</strong> {{ timbre.annee }}</li>
    <li><strong>Pays:</strong> {{ timbre.id_pays }}</li>
    <li><strong>Couleur:</strong> {{ timbre.id_couleur }}</li>
    <li><strong>Condition:</strong> {{ timbre.id_condition }}</li>
    <li><strong>Tirage:</strong> {{ timbre.tirage }}</li>
    <li><strong>Dimension:</strong> {{ timbre.dimension }}</li>
    <li><strong>Certifié:</strong> {{ timbre.certifie ? 'Oui' : 'Non' }}</li>
    <li><strong>Propriétaire ID:</strong> {{ timbre.id_proprietaire }}</li>
</ul>

{% if images is defined %}
<h2>Images:</h2>
<ul>
    {% for image in images %}
    <li>
        <img src="{{ asset }}/uploads/{{ image.url_image }}" alt="Image Timbre" width="150">
        {% if image.principale %}
        <span>Main Image</span>
        {% endif %}
    </li>
    {% endfor %}
</ul>
{% endif %}
{% else %}
<p>Timbre non trouvé.</p>
{% endif %}