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
    // Display the create stamp form    
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

    // Handle stamp creation    
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
            'certifie' => $data['certifie'] === 'Oui' ? 1 : 0, // if value Oui = 1 else = 0
            'id_proprietaire' => $_SESSION['user_id']
        ];

        $timbre_id = $timbreModel->insert($timbreData);
        if (!$timbre_id) {
            return View::render('error', ['message' => 'Impossible d\'ajouter le timbre']);
        }

        $targetDir = __DIR__ . '/../public/uploads/'; // Set target directory for uploads   

        // --- Save main image ---
        $file = $files['image_principale']; // Get main image file
        $fileName = uniqid() . '_' . basename($file['name']); // Generate unique file name
        $targetFile = $targetDir . $fileName;   // Set target file path
        move_uploaded_file($file['tmp_name'], $targetFile); // Move uploaded file to target directory

        (new ImagesTimbre())->insert([
            'id_timbre' => $timbre_id,
            'url_image' => $fileName,
            'principale' => 1
        ]);

        // --- Save additional images ---
        if (isset($files['images'])) {
            foreach ($files['images']['name'] as $i => $name) {
                if ($name == '') continue; // Skip empty file names

                $fileName = uniqid() . '_' . basename($name); // Generate unique file name
                $targetFile = $targetDir . $fileName; // Set target file path
                move_uploaded_file($files['images']['tmp_name'][$i], $targetFile); // Move uploaded file to target directory

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

    // Display the update stamp form
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
            $_SESSION['errors'] = 'Timbre introuvable ou accès refusé.';
            return View::redirect('');
        }

        $condition = new Condition();
        $conditions = $condition->select("condition");

        $couleur = new Couleur();
        $couleurs = $couleur->select("couleur");

        $pays = new Pays();
        $pays = $pays->select("pays");


        $images = (new ImagesTimbre())->selectByTimbre($timbre_id);

        return View::render('stampUpdate', [
            'timbre' => $timbre,
            'conditions' => $conditions,
            'couleurs' => $couleurs,
            'pays' => $pays,
            'images' => $images
        ]);
    }

    // Handle stamp update
    public function updateStamp($data, $queryParams)
    {
        $timbre_id = $queryParams['id'] ?? null; // Get the stamp ID from query parameters  
        if (!$timbre_id) {
            return View::render('error', ['message' => 'ID du timbre manquant']);
        }

        $timbreModel = new Timbres();
        $timbre = $timbreModel->selectId($timbre_id);

        if (!$timbre) {
            return View::render('error', ['message' => 'Timbre non trouvé']);
        }

        // Only owner can update
        if ($timbre['id_proprietaire'] != $_SESSION['user_id']) {
            $_SESSION['errors'] = 'Vous n’êtes pas autorisé à modifier ce timbre';
            return View::redirect('');
        }

        $files = $_FILES;
        $validator = new Validator();

        // Basic field validation
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

        $imageModel = new ImagesTimbre();
        $currentImgCount = $imageModel->countImagesByTimbre($timbre_id);
        // If $files['images'] is set count the number of images
        $newImgCount = isset($files['images']['name']) ? count(array_filter($files['images']['name'])) : 0;

        // Max total images validation
        $validator->field('images', $currentImgCount + $newImgCount, 'Nombre d\'images')
            ->maxValue(5);

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

        // If validation fails, re-render with inputs, errors, AND current images
        if (!$validator->isSuccess()) {
            $errors = $validator->getErrors();
            $images = $imageModel->selectByTimbre($timbre_id); // fetch existing images
            return View::render('stampUpdate', [
                'errors' => $errors,
                'inputs' => $data,
                'timbre' => $timbre,
                'pays' => (new Pays())->select('pays'),
                'couleurs' => (new Couleur())->select('couleur'),
                'conditions' => (new Condition())->select('condition'),
                'images' => $images
            ]);
        }

        // -------------------
        // Update stamp
        // -------------------
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
            'certifie' => $data['certifie'] === 'Oui' ? 1 : 0 // Certifié ou non
        ];

        $timbreModel->update($updateData, $timbre_id);

        $targetDir = __DIR__ . '/../public/uploads/'; // Set target directory for uploads

        // Replace main image
        if (isset($files['image_principale']) && $files['image_principale']['name'] != '') {
            $oldMainImage = $imageModel->selectMainByTimbre($timbre_id);
            if ($oldMainImage) {
                @unlink($targetDir . $oldMainImage['url_image']); // Delete old image file
                $imageModel->delete($oldMainImage['id']);
            }

            $file = $files['image_principale']; // Get main image file
            $fileName = uniqid() . '_' . basename($file['name']); // Generate unique file name
            move_uploaded_file($file['tmp_name'], $targetDir . $fileName); // Move uploaded file

            $imageModel->insert([
                'id_timbre' => $timbre_id,
                'url_image' => $fileName,
                'principale' => 1
            ]);
        }

        // Upload additional images
        if (isset($files['images'])) {
            foreach ($files['images']['name'] as $i => $name) {
                if ($name == '') continue; // Skip empty file names
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
        // Ensure user is authenticated
        Auth::session();
        // Check if user is authorized to delete the image
        $imageId = $_POST['id'] ?? null;

        header('Content-Type: application/json');
        if (!$imageId) {
            echo json_encode(['success' => false, 'message' => 'ID manquant']);
            exit;
        }

        $imageModel = new ImagesTimbre();
        $image = $imageModel->selectId($imageId);
        if (!$image) {
            echo json_encode(['success' => false, 'message' => 'Image non trouvée']);
            exit;
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
