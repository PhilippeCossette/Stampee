{{ include("layouts/header.php", { title: "Ajoutez votre Timbre - Stampee" }) }}
<div class="wrapper-centered margin-block">
    <!-- enctype="multipart/form-data" permert l'upload d'image -->
    <form class="form" action="{{ base }}/create" method="post" enctype="multipart/form-data">
        <header class="form-header">
            <p class="form-header-undertitle">Entrez les informations du timbre</p>
            <h1 class="form-header-title">Ajoutez Votre Timbre</h1>
        </header>
        <div>
            <input
                class="form-input"
                type="text"
                id="titre"
                name="titre"
                placeholder="Titre"
                required />
            {% if errors.titre is defined %}
            <span class="error">{{ errors.titre }}</span>
            {% endif %}
        </div>
        <div>
            <textarea class="form-input" name="description" id="description" placeholder="Description"></textarea>
            {% if errors.description is defined %}
            <span class="error">{{ errors.description }}</span>
            {% endif %}
        </div>
        <div>
            <label for="annee">Année :</label>
            <input
                class="form-small-input"
                type="number"
                id="annee"
                name="annee"
                min="1000"
                max="2100"
                step="1"
                value="{{ inputs.annee ?? '' }}"
                required>

            {% if errors.annee is defined %}
            <span class="error">{{ errors.annee }}</span>
            {% endif %}
        </div>
        <div class="form-selectWrapper">
            <div>
                <select class="form-small-input" id="id_pays" name="id_pays" require>
                    <option value="">Select Pays</option>
                    {% for pays in pays %}
                    <option value="{{ pays.id_pays }}" {% if(inputs.id_pays == pays.id_pays) %} selected {% endif %}>
                        {{ pays.pays }}
                    </option>
                    {% endfor %}
                </select>
                {% if errors.id_pays is defined %}
                <span class="error">{{ errors.id_pays }}</span>
                {% endif %}
            </div>
            <div>
                <select class="form-small-input" id="id_couleur" name="id_couleur" require>
                    <option value="">Select Couleur</option>
                    {% for coul in couleurs %}
                    <option value="{{ coul.id_couleur }}" {% if(inputs.id_couleur == coul.id_couleur) %} selected {% endif %}>
                        {{ coul.couleur }}
                    </option>
                    {% endfor %}
                </select>
                {% if errors.id_couleur is defined %}
                <span class="error">{{ errors.id_couleur }}</span>
                {% endif %}
            </div>
            <div>
                <select class="form-small-input" id="id_condition" name="id_condition" require>
                    <option value="">Select Condition</option>
                    {% for cond in conditions %}
                    <option value="{{ cond.id_condition }}" {% if(inputs.id_condition == cond.id_condition) %} selected {% endif %}>
                        {{ cond.condition }}
                    </option>
                    {% endfor %}
                </select>
                {% if errors.id_condition is defined %}
                <span class="error">{{ errors.id_condition }}</span>
                {% endif %}
            </div>
        </div>
        <div>
            <label for="tirage">Tirage :</label>
            <input
                class="form-small-input"
                type="number"
                id="tirage"
                name="tirage"
                step="1"
                value="{{ inputs.tirage ?? '' }}"
                required>

            {% if errors.tirage is defined %}
            <span class="error">{{ errors.tirage }}</span>
            {% endif %}
        </div>

        <div>
            <label for="width">Width (mm):</label>
            <input class="form-small-input" type="number" id="width" name="width" min="1" step="0.1" required>
            {% if errors.width is defined %}
            <span class="error">{{ errors.width }}</span>
            {% endif %}
            <label for="height">Height (mm):</label>
            <input class="form-small-input" type="number" id="height" name="height" min="1" step="0.1" required>
            {% if errors.height is defined %}
            <span class="error">{{ errors.height }}</span>
            {% endif %}
        </div>

        <div>
            <label for="certifie">Certifié ?</label>
            <select class="form-small-input" name="certifie">
                <option value="" {% if inputs.certifie is not defined or inputs.certifie == '' %} selected {% endif %}>Select</option>
                <option value="Oui" {% if(inputs.certifie == 'Oui') %} selected {% endif %}>Oui</option>
                <option value="Non" {% if(inputs.certifie == 'Non') %} selected {% endif %}>Non</option>
            </select>
            {% if errors.certifie is defined %}
            <span class="error">{{ errors.certifie }}</span>
            {% endif %}
        </div>

        <div>
            <label for="image_principale">Image principale (obligatoire) :</label>
            <input type="file" id="image_principale" name="image_principale" accept="image/*" required>
            {% if errors.image_principale is defined %}
            <p class="error">{{ errors.image_principale }}</p>
            {% endif %}
        </div>
        <div>
            <label for="images">Autres images (facultatif) :</label>
            <input type="file" id="images" name="images[]" multiple accept="image/*">
            {% for key, error in errors %}
            {% if key starts with 'images[' %}
            <p class="error">{{ error }}</p>
            {% endif %}
            {% endfor %}
        </div>

        <button class="main-button" type="submit">Créer un timbre </button>
    </form>
</div>

{{ include("layouts/footer.php") }}