<form method="POST" action="{{ base }}/bid/store">
    <p>{{ auction.prix_actuel }}</p>

    <input type="hidden" name="id_enchere" value="{{ auction.enchere_id }}">
    <input type="number" name="montant" placeholder="Entrez votre offre">
    {% if errors.montant is defined %}
    <p class="error">{{ errors.montant }}</p>
    {% endif %}
    <button type="submit">Enchérir</button>
</form>