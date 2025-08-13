<?php

namespace App\Controllers;

use App\Models\Condition; 
use App\Models\Couleur; 
use App\Models\Pays; 

use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class StampController {
    public function createIndex(){
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



}