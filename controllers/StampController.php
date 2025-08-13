<?php

namespace App\Controllers;

use App\Models\Timbres;
use App\Models\Condition;
use App\Models\Couleur;
use App\Models\Pays;

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
        // Validate required fields
        $validator->field('titre', $data['titre'])->required()->min(2)->max(100);
        $validator->field('annee', $data['annee'])->required()->number()->min(1000)->max(2100);
        $validator->field('id_pays', $data['id_pays'])->required()->number();
        $validator->field('id_couleur', $data['id_couleur'])->required()->number();
        $validator->field('id_condition', $data['id_condition'])->required()->number();
        $validator->field('tirage', $data['tirage'])->required()->number()->min(1);
        $validator->field('width', $data['width'])->required()->number()->min(1);
        $validator->field('height', $data['height'])->required()->number()->min(1);
        $validator->field('certifie', $data['certifie'])->required();


        if ($validator->isSuccess()) {
            $timbreModel = new Timbres();

            $dimension = $data['width'] . 'x' . $data['height']; // Combine width and height for dimension  

            $timbreData = [
                'titre' => $data['titre'],
                'annee' => $data['annee'],
                'id_pays' => $data['id_pays'],
                'id_couleur' => $data['id_couleur'],
                'id_condition' => $data['id_condition'],
                'tirage' => $data['tirage'],
                'dimension' => $data[$dimension],
                'certifie' => $data['certifie'] === 'Oui' ? 1 : 0
            ];

            $timbre_id = $timbreModel->insert($timbreData);

            if (!$timbre_id) {
                return View::render('error', ['message' => 'Impossible d\'ajouter le timbre']);
            }

            $targetDir = __DIR__ . '/../public/uploads/';
        }
    }
}
