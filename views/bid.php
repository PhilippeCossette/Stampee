<form method="POST" action="{{ base }}/bid/store">
    <input type="hidden" name="id_enchere" value="{{ auction.enchere_id }}">
    <input type="number" name="montant" placeholder="Entrez votre offre">
    <button type="submit">Enchérir</button>
</form>