<?php

namespace App\Controllers;

use App\Models\Favoris;
use App\Models\Utilisateur;
use App\Models\Encheres;
use App\Models\Mises;
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

        // Update auction status    
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        // Get user favorites   
        $favorisModel = new Favoris();
        $favoris = $favorisModel->getFavByUserId($_SESSION['user_id'], 4);

        // Get user auctions
        $enchereModel = new Encheres();
        $mesEncheres = $enchereModel->getMyAuction($_SESSION['user_id'], 4);

        // Get user bids
        $misesModel = new Mises();
        $mesMises = $misesModel->getMyBidLog($_SESSION['user_id'], 10);

        // Read session messages
        $success = $_SESSION['success'] ?? null;
        $errors = $_SESSION['errors'] ?? null;
        // Unset after reading
        unset($_SESSION['errors'], $_SESSION['success']);

        return View::render('profile', ['favoris' => $favoris, 'mesEncheres' => $mesEncheres, 'mesMises' => $mesMises, 'success' => $success, 'errors' => $errors]);
    }

    public function profileFavorites()
    {
        Auth::session(); // Ensure the user is authenticated

        // Update auction status
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        $favorisModel = new Favoris();
        $favoris = $favorisModel->getFavByUserId($_SESSION['user_id']);

        return View::render('myFavorites', ['favoris' => $favoris]);
    }

    public function profileMyAuctions()
    {
        Auth::session(); // Ensure the user is authenticated

        // Update auction status
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        $enchereModel = new Encheres();
        $mesEncheres = $enchereModel->getMyAuction($_SESSION['user_id']);

        return View::render('myAuction', ['mesEncheres' => $mesEncheres]);
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
            $_SESSION['success'] = 'Profil mis à jour avec succès.';
            return View::redirect('profile');
        }

        $_SESSION['errors'] = 'Erreur lors de la mise à jour du profil.';
        return View::redirect('profile');
    }

    // Handle user deletion
    public function deleteUser()
    {
        Auth::session(); // Ensure the user is connected
        $userModel = new Utilisateur();

        if ($userModel->deleteUserAccount($_SESSION['user_id'])) {
            session_unset();
            session_destroy();
            return View::redirect('');
        } else {
            return View::render('profile', ['errors' => 'Erreur lors de la suppression du compte.']);
        }
    }
}
