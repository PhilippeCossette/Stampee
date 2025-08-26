{{ include("layouts/header.php", { title: "Mes favoris - Stampee" }) }}
<section class="max-1200 inlineP-huge">
    <article class="profile-section">
        <header class="profile-section-header">
            <h2 class="profile-section-header-title">Mes Mises</h2>
            <a class="profile-section-header-link" href="{{ base }}/profile">Voir Tout <i class="fa-solid fa-angle-right"></i></a>
        </header>
        {% if mesMises is not empty %}
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Enchère</th>
                        <th>Montant de la mise</th>
                        <th>Date de la mise</th>
                        <th>Temps restant</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    {% for mise in mesMises %}
                    <tr>
                        <td><a href="{{ base }}/auction?id={{ mise.enchere_id }}">{{ mise.titre }}<i class="fa-solid fa-angle-right"></i></a></td>
                        {% if mise.montant >= mise.highest_bid %}
                        <td class="green-text">{{ mise.montant }} $</td>
                        {% else %}
                        <td class="red-text">{{ mise.montant }} $</td>
                        {% endif %}
                        <td>{{ mise.date_heure|date("d/m/Y H:i") }}</td>
                        {% if mise.status == 1 %}
                        <td><span class="timer" data-fin="{{ mise.fin }}"></span></td>
                        {% else %}
                        <td><span class="red-text">Terminé</span></td>
                        {% endif %}
                        <td>
                            {% if mise.status == 1 %}
                            <span class="status-indicator active">En cours</span>
                            {% elseif mise.status == 0 %}
                            {% if mise.is_highest_bidder %}
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
    </article>
</section>
{{ include("layouts/footer.php") }}