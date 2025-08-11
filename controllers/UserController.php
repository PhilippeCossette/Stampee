<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Providers\View;
use App\Providers\Auth; 

class UserController {
    public function profileIndex() {
        Auth::session(); // Ensure the user is authenticated
        return View::render('profile');
    }

    public function deleteUser() {
        $userModel = new Utilisateur();
        $userId = $_SESSION['user_id'];

        if ($userModel->delete($userId)) {
            session_unset();
            session_destroy();
            return View::redirect('login');
    } else {
            return View::render('profile', ['error' => 'Erreur lors de la suppression du compte.']);
    }
    }
}