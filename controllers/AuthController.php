<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Providers\View;
use App\Providers\Validator;

class AuthController {
    public function index() {
        return View::render('register');
    }

    public function registerAccount() {

        $nom = $_POST['nom_utilisateur'];
        $email = $_POST['email'];
        $motDePasse = $_POST['mot_de_passe'];
        
        $validator = new Validator();
        $validator->field('nom_utilisateur', $nom, 'Nom d\'utilisateur')->required()->min(3)->max(50);
        $validator->field('email', $email, 'Adresse courriel')->required()->email()->unique("Utilisateur");
        $validator->field('mot_de_passe', $motDePasse, 'Mot de passe')->required()->min(6)->max(40);

        if ($validator->isSuccess()) {
            $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);
            $data = [
                'nom_utilisateur' => $nom,
                'email' => $email,
                'mot_de_passe' => $hashedPassword
            ];

            $utilisateurModel = new Utilisateur();
            $insertId = $utilisateurModel->insert($data);
        


        if ($insertId) {
            // Save user ID in session to log them in (optional)
            $_SESSION['user_id'] = $insertId;
            // Redirect or show success message
            echo "User registered successfully! User ID: $insertId";
        } else {
            echo "Failed to register user.";
        }
    } else {
        $errors = $validator->getErrors();
        return View::render('register', ['errors' => $errors, 'inputs' => $_POST]);
    }

    }
}
