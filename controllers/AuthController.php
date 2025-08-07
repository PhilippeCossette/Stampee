<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Providers\View;

class AuthController {
    public function index() {
        return View::render('registration');
    }

    public function registerAccount() {
        $nom = $_POST['nom_utilisateur'] ?? '';
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);

        $data = [
            'nom_utilisateur' => $nom,
            'email' => $email,
            'mot_de_passe' => $hashedPassword,
        ];

        $utilisateurModel = new Utilisateur();
        $insertId = $utilisateurModel->insert($data);

        if ($insertId) {
            echo "User registered successfully! User ID: $insertId";
            // You can redirect or load a success view here instead
        } else {
            echo "Failed to register user.";
        }
    }

}