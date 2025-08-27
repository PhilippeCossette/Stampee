{{ include("layouts/header.php", { title: "Modifier Timbre - Stampee" }) }}

<div class="wrapper-centered margin-block">
    <form class="form" action="{{ base }}/stamp/update?id={{ timbre.id }}" method="post" enctype="multipart/form-data">
        <header class="form-header">
            <p class="form-header-undertitle">Modifiez les informations du timbre</p>
            <h1 class="form-header-title">Modifier Votre Timbre</h1>
        </header>

        <div>
            <input
                class="form-input"
                type="text"
                id="titre"
                name="titre"
                placeholder="Titre"
                value="{{ inputs.titre ?? timbre.titre }}"
                required />
            {% if errors.titre is defined %}
            <span class="error">{{ errors.titre }}</span>
            {% endif %}
        </div>

        <div>
            <textarea class="form-input" name="description" id="description" placeholder="Description" required>{{ inputs.description ?? timbre.description }}</textarea>
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
                value="{{ inputs.annee ?? timbre.annee }}"
                required>
            {% if errors.annee is defined %}
            <span class="error">{{ errors.annee }}</span>
            {% endif %}
        </div>

        <div class="form-selectWrapper">
            <div>
                <select class="form-small-input" id="id_pays" name="id_pays" required>
                    <option value="">Select Pays</option>
                    {% for p in pays %}
                    <option value="{{ p.id_pays }}" {% if(inputs.id_pays ?? timbre.id_pays) == p.id_pays %} selected {% endif %}>{{ p.pays }}</option>
                    {% endfor %}
                </select>
                {% if errors.id_pays is defined %}
                <span class="error">{{ errors.id_pays }}</span>
                {% endif %}
            </div>
            <div>
                <select class="form-small-input" id="id_couleur" name="id_couleur" required>
                    <option value="">Select Couleur</option>
                    {% for c in couleurs %}
                    <option value="{{ c.id_couleur }}" {% if(inputs.id_couleur ?? timbre.id_couleur) == c.id_couleur %} selected {% endif %}>{{ c.couleur }}</option>
                    {% endfor %}
                </select>
                {% if errors.id_couleur is defined %}
                <span class="error">{{ errors.id_couleur }}</span>
                {% endif %}
            </div>
            <div>
                <select class="form-small-input" id="id_condition" name="id_condition" required>
                    <option value="">Select Condition</option>
                    {% for cond in conditions %}
                    <option value="{{ cond.id_condition }}" {% if(inputs.id_condition ?? timbre.id_condition) == cond.id_condition %} selected {% endif %}>{{ cond.condition }}</option>
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
                value="{{ inputs.tirage ?? timbre.tirage }}"
                required>
            {% if errors.tirage is defined %}
            <span class="error">{{ errors.tirage }}</span>
            {% endif %}
        </div>

        <div>
            <label for="width">Width (mm):</label>
            <input class="form-small-input" type="number" id="width" name="width" min="1" step="0.1" value="{{ inputs.width ?? timbre.dimension|split('x')[0] }}" required>
            {% if errors.width is defined %}
            <span class="error">{{ errors.width }}</span>
            {% endif %}

            <label for="height">Height (mm):</label>
            <input class="form-small-input" type="number" id="height" name="height" min="1" step="0.1" value="{{ inputs.height ?? timbre.dimension|split('x')[1] }}" required>
            {% if errors.height is defined %}
            <span class="error">{{ errors.height }}</span>
            {% endif %}
        </div>

        <div>
            <label for="certifie">Certifié ?</label>
            <select class="form-small-input" name="certifie">
                <option value="">Select</option>
                <option value="Oui" {% if(inputs.certifie ?? (timbre.certifie ? 'Oui' : 'Non')) == 'Oui' %} selected {% endif %}>Oui</option>
                <option value="Non" {% if(inputs.certifie ?? (timbre.certifie ? 'Oui' : 'Non')) == 'Non' %} selected {% endif %}>Non</option>
            </select>
            {% if errors.certifie is defined %}
            <span class="error">{{ errors.certifie }}</span>
            {% endif %}
        </div>


        <div>
            {% for image in images %}
            {% if image.principale == 1 %}
            <div>
                <img src="{{ asset }}/uploads/{{ image.url_image }}" alt="Image principale" width="200">
            </div>
            {% endif %}
            {% endfor %}
            <label for="image_principale">Remplacez l'image principale :</label>
            <input type="file" id="image_principale" name="image_principale" accept="image/*">
            {% if errors.image_principale is not defined %}
            <span class="error">{{ errors.image_principale }}</span>
            {% endif %}
        </div>

        <div>
            <label for="images">Ajoutez d'Autres images :</label>
            <input type="file" id="images" name="images[]" multiple accept="image/*">
            {% for key, error in errors %}
            {% if key starts with 'images[' %}
            <span class="error">{{ error }}</span>
            {% endif %}
            {% endfor %}
        </div>

        <div class="delete-img">
            {% for img in images %}
            {% if img.principale == 0 %}
            <div class="img-container" data-id="{{ img.id }}">
                <img src="{{ base }}/public/uploads/{{ img.url_image }}" alt="Image" width="150">
                <button type="button" class="delete-button"><i class="fa-solid fa-trash"></i></button>
            </div>
            {% endif %}
            {% endfor %}
        </div>

        <button class="button main-button" type="submit">Mettre à jour le timbre</button>
    </form>
</div>

{{ include("layouts/footer.php") }}