{{ include("layouts/header.php", { title: "Tout les offres de l'enchère - Stampee" }) }}
<section>
    <header class="profile-section-header">
        <h2 class="profile-section-header-title">Mises récentes</h2>
        <a class="profile-section-header-link" href="{{ base }}/auction?id={{ enchere_id }}">Retour <i class="fa-solid fa-angle-right"></i></a>
    </header>
    {% if bids is not empty %}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Montant de la mise</th>
                    <th>Date de la mise</th>
                    <th>Temps restant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                {% for bid in bids %}
                <tr>
                    <td>{{ bid.nom_utilisateur }}</td>
                    {% if bid.montant >= bid.highest_bid %}
                    <td class="green-text">{{ bid.montant }} $</td>
                    {% else %}
                    <td class="red-text">{{ bid.montant }} $</td>
                    {% endif %}
                    <td>{{ bid.date_heure|date("d/m/Y H:i") }}</td>
                    {% if bid.status == 1 %}
                    <td><span class="timer" data-fin="{{ bid.fin }}"></span></td>
                    {% else %}
                    <td><span class="red-text">Terminé</span></td>
                    {% endif %}
                    <td>
                        {% if bid.status == 1 %}
                        <span class="status-indicator active">En cours</span>
                        {% elseif bid.status == 0 %}
                        {% if bid.is_highest_bidder %}
                        <span class="status-indicator won">Gagnée</span>
                        {% else %}
                        <span class="status-indicator lost">Perdue</span>
                        {% endif %}
                        {% else %}
                        <span class="status-indicator unknown">Inconnu</span>
                        {% endif %}
                    </td>
                </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
    {% else %}
    <p class="empty-message">Aucune mise trouvée.</p>
    {% endif %}
</section>
{{ include("layouts/footer.php") }}