<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Providers\Validator;
use App\Providers\View;
use App\Providers\Auth;

// This controller handles user profile management
class UserController
{
    // Render the user profile page
    public function profileIndex()
    {
        Auth::session(); // Ensure the user is authenticated
        return View::render('profile');
    }

    public function updateIndex($data = [])
    {
        Auth::session(); // Ensure the user is authenticated    
        $userId = $_SESSION['user_id'];

        $userModel = new Utilisateur();
        $userData = $userModel->selectId($userId);
        return View::render('update', ['inputs' => $userData]);
    }

    // Handle user profile update   
    public function updateUser()
    {
        Auth::session(); // Ensure the user is authenticated
        $userId = $_SESSION['user_id'];

        $nom = $_POST['nom_utilisateur'];
        $email = $_POST['email'];
        $motDePasse = $_POST['mot_de_passe'];

        $validator = new Validator();
        $validator->field('nom_utilisateur', $nom, 'Nom d\'utilisateur')->required()->min(3)->max(50);
        $validator->field('email', $email, 'Adresse courriel')->required()->email()->uniqueUpdate("Utilisateur", $userId);

        // Validate password only if entered
        if (!empty($motDePasse)) {
            $validator->field('mot_de_passe', $motDePasse, 'Mot de passe')->required()->min(6)->max(40);
        }

        if (!$validator->isSuccess()) {
            $errors = $validator->getErrors();
            return View::render('update', ['errors' => $errors, 'inputs' => $_POST]);
        }

        $data = [
            'nom_utilisateur' => $nom,
            'email' => $email
        ];

        if (!empty($motDePasse)) {
            $data["mot_de_passe"] = password_hash($motDePasse, PASSWORD_DEFAULT);
        } else {
            unset($motDePasse); // Do not update password if not provided   
        }

        $userModel = new Utilisateur();
        $update = $userModel->update($data, $userId);

        if ($update) {
            $_SESSION['nom_utilisateur'] = $data['nom_utilisateur'];
            $_SESSION['email'] = $data['email'];
            return View::redirect('profile', ['success' => 'Profile mis à jour avec succès.']);
        } else {
            return View::render('error', ['message' => 'Erreur lors de la mise à jour du profil.']);
        }
    }

    // Handle user deletion
    public function deleteUser()
    {
        Auth::session(); // Ensure the user is connected
        $userModel = new Utilisateur();
        $userId = $_SESSION['user_id'];

        if ($userModel->delete($userId)) {
            session_unset();
            session_destroy();
            return View::redirect('', ['success' => 'Compte supprimé avec succès.']);
        } else {
            return View::render('profile', ['error' => 'Erreur lors de la suppression du compte.']);
        }
    }
}
