<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class AuthController {

    // Render the registration page
    public function registerIndex() {
        return View::render('register');
    }

    // Render the login page
    public function loginIndex() {
        return View::render('login');
    }


    // Handle user registration
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
            session_regenerate_id();

            $_SESSION['user_id'] = $insertId;
            $_SESSION['nom_utilisateur'] = $nom;
            $_SESSION['email'] = $email;
            $_SESSION['finger_print'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            
            return View::redirect(''); // Redirect to homepage after successful registration
        } else {
            echo "Failed to register user.";
        }
    } else {
        $errors = $validator->getErrors();
        return View::render('register', ['errors' => $errors, 'inputs' => $_POST]);
    }
    }

    // Handle user login
    public function login($data){
        $validator = new Validator();
        $nom = $_POST['nom_utilisateur'];
        $motDePasse = $_POST['mot_de_passe'];   
        $validator->field("nom_utilisateur", $nom, "Nom d'utilisateur")->required()->min(3)->max(50);
        $validator->field("mot_de_passe", $motDePasse, "Mot de passe")->required()->min(6)->max(40);
        if ($validator->isSuccess()) {
            $utilisateurModel = new Utilisateur();
            $isAuthenticated = $utilisateurModel->checkUser($nom, $motDePasse);
            if ($isAuthenticated) {
                return View::redirect(''); // Redirect to homepage after successful login
            } else {
                $errors["message"] = "Nom d'utilisateur ou mot de passe incorrect.";
                return View::render('login', ['errors' => $errors, 'inputs' => $data]);
            }
        } else {    
            $errors = $validator->getErrors();
            return View::render('login', ['errors' => $errors, 'inputs' => $data]);
        }
    }

    // Handle user logout   
    public function logout(){
        session_destroy(); // End session
        return View::redirect(''); // Redirect to login
    }
}
