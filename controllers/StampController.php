<?php

namespace App\Controllers;

use App\Models\Timbres;
use App\Models\Condition;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\ImagesTimbre;

use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class StampController
{
    public function createIndex()
    {
        Auth::session(); // Ensure the user is authenticated

        // Fetch All external Tables
        $condition = new Condition();
        $conditions = $condition->select("condition");

        $couleur = new Couleur();
        $couleurs = $couleur->select("couleur");

        $pays = new Pays();
        $pays = $pays->select("pays");

        return View::render('create', [
            'conditions' => $conditions,
            'couleurs' => $couleurs,
            'pays' => $pays
        ]);
    }

    public function storeStamp($data)
    {
        $files = $_FILES; // Retrieve uploaded files
        $validator = new Validator();

        // --- Validate form inputs ---
        $validator->field('titre', $data['titre'])->required()->min(2)->max(100);
        $validator->field('description', $data['description'])->required()->min(2)->max(200);
        $validator->field('annee', $data['annee'])->required()->number();
        $validator->field('id_pays', $data['id_pays'])->required()->number();
        $validator->field('id_couleur', $data['id_couleur'])->required()->number();
        $validator->field('id_condition', $data['id_condition'])->required()->number();
        $validator->field('tirage', $data['tirage'])->required()->number()->min(1);
        $validator->field('width', $data['width'])->required()->number()->min(1);
        $validator->field('height', $data['height'])->required()->number()->min(1);
        $validator->field('certifie', $data['certifie'])->required();

        // --- Validate main image ---
        if (isset($files['image_principale']) && $files['image_principale']['name'] != '') {
            $validator->file('image_principale', $files['image_principale'])
                ->requiredFile()
                ->maxSizeFile(2 * 1024 * 1024) // 2 MB
                ->allowedTypesFile(['image/jpeg', 'image/png'])
                ->maxDimensionsFile(2000, 2000); // max width x height
        } else {
            $validator->file('image_principale', ['tmp_name' => null])->requiredFile();
        }

        // --- Validate additional images ---
        if (isset($files['images'])) {
            foreach ($files['images']['name'] as $i => $name) {
                if ($name == '') continue;

                $fileArray = [
                    'name' => $files['images']['name'][$i],
                    'tmp_name' => $files['images']['tmp_name'][$i],
                    'size' => $files['images']['size'][$i],
                    'type' => $files['images']['type'][$i],
                    'error' => $files['images']['error'][$i]
                ];

                $validator->file("images[$i]", $fileArray)
                    ->maxSizeFile(2 * 1024 * 1024)
                    ->allowedTypesFile(['image/jpeg', 'image/png'])
                    ->maxDimensionsFile(2000, 2000);
            }
        }

        if (!$validator->isSuccess()) {
            $errors = $validator->getErrors();
            return View::render('create', [
                'errors' => $errors,
                'inputs' => $data,
                'pays' => (new Pays())->select('pays'),
                'couleurs' => (new Couleur())->select('couleur'),
                'conditions' => (new Condition())->select('condition')
            ]);
        }

        // --- Insert timbre ---
        $timbreModel = new Timbres();
        $dimension = $data['width'] . 'x' . $data['height'];
        $timbreData = [
            'titre' => $data['titre'],
            'description' => $data['description'],
            'annee' => $data['annee'],
            'id_pays' => $data['id_pays'],
            'id_couleur' => $data['id_couleur'],
            'id_condition' => $data['id_condition'],
            'tirage' => $data['tirage'],
            'dimension' => $dimension,
            'certifie' => $data['certifie'] === 'Oui' ? 1 : 0,
            'id_proprietaire' => $_SESSION['user_id']
        ];

        $timbre_id = $timbreModel->insert($timbreData);
        if (!$timbre_id) {
            return View::render('error', ['message' => 'Impossible d\'ajouter le timbre']);
        }

        $targetDir = __DIR__ . '/../public/uploads/';

        // --- Save main image ---
        $file = $files['image_principale'];
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($file['tmp_name'], $targetFile);

        (new ImagesTimbre())->insert([
            'id_timbre' => $timbre_id,
            'url_image' => $fileName,
            'principale' => 1
        ]);

        // --- Save additional images ---
        if (isset($files['images'])) {
            foreach ($files['images']['name'] as $i => $name) {
                if ($name == '') continue;

                $fileName = uniqid() . '_' . basename($name);
                $targetFile = $targetDir . $fileName;
                move_uploaded_file($files['images']['tmp_name'][$i], $targetFile);

                (new ImagesTimbre())->insert([
                    'id_timbre' => $timbre_id,
                    'url_image' => $fileName,
                    'principale' => 0
                ]);
            }
        }

        $_SESSION['success'] = 'Timbre créé avec succès ! En attente d\'approbation.';
        return View::redirect('');
    }

    public function updateStampIndex() // Gets from Url ?id=5 exemple
    {
        Auth::session();


        $timbre_id = $_GET['id'] ?? null;
        if (!$timbre_id) {
            return View::render('error', ['message' => 'ID du timbre manquant']);
        }

        $timbreModel = new Timbres();
        $timbre = $timbreModel->selectId($timbre_id);

        if (!$timbre || $timbre['id_proprietaire'] != $_SESSION['user_id']) {
            return View::render('error', ['message' => 'Timbre introuvable ou accès refusé.']);
        }

        $condition = new Condition();
        $conditions = $condition->select("condition");

        $couleur = new Couleur();
        $couleurs = $couleur->select("couleur");

        $pays = new Pays();
        $pays = $pays->select("pays");

        /// Need changes
        $images = (new ImagesTimbre())->selectByTimbre($timbre_id);


        return View::render('stampUpdate', [
            'timbre' => $timbre,
            'conditions' => $conditions,
            'couleurs' => $couleurs,
            'pays' => $pays,
            'images' => $images
        ]);
    }

    public function updateStamp($data, $queryParams)
    {
        $timbre_id = $queryParams['id'] ?? null;
        if (!$timbre_id) {
            return View::render('error', ['message' => 'ID du timbre manquant']);
        }

        $timbreModel = new Timbres();
        $timbre = $timbreModel->selectId($timbre_id);

        if (!$timbre) {
            return View::render('error', ['message' => 'Timbre non trouvé']);
        }

        // Only owner can update
        if (!$timbre || $timbre['id_proprietaire'] != $_SESSION['user_id']) {
            return View::render('error', ['message' => 'Vous n’êtes pas autorisé à modifier ce timbre']);
        }

        $files = $_FILES;
        $validator = new Validator();

        // Validate fields (same as storeStamp)
        $validator->field('titre', $data['titre'])->required()->min(2)->max(100);
        $validator->field('description', $data['description'])->required()->min(2)->max(200);
        $validator->field('annee', $data['annee'])->required()->number();
        $validator->field('id_pays', $data['id_pays'])->required()->number();
        $validator->field('id_couleur', $data['id_couleur'])->required()->number();
        $validator->field('id_condition', $data['id_condition'])->required()->number();
        $validator->field('tirage', $data['tirage'])->required()->number()->min(1);
        $validator->field('width', $data['width'])->required()->number()->min(1);
        $validator->field('height', $data['height'])->required()->number()->min(1);
        $validator->field('certifie', $data['certifie'])->required();

        // Validate main image if uploaded
        if (isset($files['image_principale']) && $files['image_principale']['name'] != '') {
            $validator->file('image_principale', $files['image_principale'])
                ->maxSizeFile(2 * 1024 * 1024)
                ->allowedTypesFile(['image/jpeg', 'image/png'])
                ->maxDimensionsFile(2000, 2000);
        }

        // Validate additional images
        if (isset($files['images'])) {
            foreach ($files['images']['name'] as $i => $name) {
                if ($name == '') continue;

                $fileArray = [
                    'name' => $files['images']['name'][$i],
                    'tmp_name' => $files['images']['tmp_name'][$i],
                    'size' => $files['images']['size'][$i],
                    'type' => $files['images']['type'][$i],
                    'error' => $files['images']['error'][$i]
                ];

                $validator->file("images[$i]", $fileArray)
                    ->maxSizeFile(2 * 1024 * 1024)
                    ->allowedTypesFile(['image/jpeg', 'image/png'])
                    ->maxDimensionsFile(2000, 2000);
            }
        }

        if (!$validator->isSuccess()) {
            $errors = $validator->getErrors();
            return View::render('stampUpdate', [
                'errors' => $errors,
                'inputs' => $data,
                'timbre' => $timbre,
                'pays' => (new Pays())->select('pays'),
                'couleurs' => (new Couleur())->select('couleur'),
                'conditions' => (new Condition())->select('condition')
            ]);
        }

        // Update stamp data
        $dimension = $data['width'] . 'x' . $data['height'];
        $updateData = [
            'titre' => $data['titre'],
            'description' => $data['description'],
            'annee' => $data['annee'],
            'id_pays' => $data['id_pays'],
            'id_couleur' => $data['id_couleur'],
            'id_condition' => $data['id_condition'],
            'tirage' => $data['tirage'],
            'dimension' => $dimension,
            'certifie' => $data['certifie'] === 'Oui' ? 1 : 0
        ];

        $timbreModel->update($updateData, $timbre_id);

        $targetDir = __DIR__ . '/../public/uploads/';

        $imageModel = new ImagesTimbre();
        $oldMainImage = $imageModel->selectMainByTimbre($timbre_id);

        // Replace main image
        if (isset($files['image_principale']) && $files['image_principale']['name'] != '') {
            // Delete old main image if exists
            if ($oldMainImage) {
                @unlink($targetDir . $oldMainImage['url_image']); // Delete old main image
                $imageModel->delete($oldMainImage['id']); // Remove from DB
            }
            // Upload new main image
            $file = $files['image_principale'];
            $fileName = uniqid() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $targetDir . $fileName);

            $imageModel->insert([
                'id_timbre' => $timbre_id,
                'url_image' => $fileName,
                'principale' => 1
            ]);
        }

        // Additional images
        if (isset($files['images'])) {
            foreach ($files['images']['name'] as $i => $name) {
                if ($name == '') continue;
                $fileName = uniqid() . '_' . basename($name);
                move_uploaded_file($files['images']['tmp_name'][$i], $targetDir . $fileName);

                $imageModel->insert([
                    'id_timbre' => $timbre_id,
                    'url_image' => $fileName,
                    'principale' => 0
                ]);
            }
        }

        $_SESSION['success'] = 'Timbre mis à jour avec succès !';
        return View::redirect('profile');
    }

    public function deleteImage()
    {
        Auth::session();
        $imageId = $_POST['image_id'] ?? null;
        if (!$imageId) {
            echo json_encode(['success' => false, 'message' => 'ID manquant']);
            return;
        }

        $imageModel = new ImagesTimbre();
        $image = $imageModel->selectbyId($imageId);
        if (!$image) {
            echo json_encode(['success' => false, 'message' => 'Image non trouvée']);
            return;
        }

        // Delete image file
        $targetDir = __DIR__ . '/../public/uploads/';
        @unlink($targetDir . $image['url_image']);

        // Delete image from database
        $deleted = $imageModel->delete($imageId);
        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Suppression impossible']);
        }
    }
}
