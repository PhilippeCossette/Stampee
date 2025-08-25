<?php

namespace App\Controllers;

use App\Models\Favoris;
use App\Models\Utilisateur;
use App\Models\Encheres;
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

        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        $favorisModel = new Favoris();
        $favoris = $favorisModel->getFavByUserId($_SESSION['user_id'], 4);

        return View::render('profile', ['favoris' => $favoris]);
    }

    public function profileFavorites()
    {
        Auth::session(); // Ensure the user is authenticated

        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        $favorisModel = new Favoris();
        $favoris = $favorisModel->getFavByUserId($_SESSION['user_id']);

        return View::render('myFavorites', ['favoris' => $favoris]);
    }

    public function updateIndex()
    {
        Auth::session(); // Ensure the user is authenticated    

        $userModel = new Utilisateur();
        $userData = $userModel->selectId($_SESSION['user_id']);
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

        $userModel = new Utilisateur();
        if ($userModel->updateUserData($userId, $nom, $email, $motDePasse)) {
            $_SESSION['nom_utilisateur'] = $nom;
            $_SESSION['email'] = $email;
            return View::redirect('profile', ['success' => 'Profil mis à jour avec succès.']);
        }

        return View::render('error', ['message' => 'Erreur lors de la mise à jour du profil.']);
    }

    // Handle user deletion
    public function deleteUser()
    {
        Auth::session(); // Ensure the user is connected
        $userModel = new Utilisateur();

        if ($userModel->deleteUserAccount($_SESSION['user_id'])) {
            session_unset();
            session_destroy();
            return View::redirect('', ['success' => 'Compte supprimé avec succès.']);
        } else {
            return View::render('profile', ['error' => 'Erreur lors de la suppression du compte.']);
        }
    }
}
