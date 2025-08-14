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
}
