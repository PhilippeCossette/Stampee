<?php

namespace App\Controllers;

use App\Models\Encheres;

use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

// This controller handles the home page rendering
class HomeController
{
    public function index()
    {
        $success = $_SESSION['success'] ?? null;
        $errors = $_SESSION['errors'] ?? null;
        unset($_SESSION['errors']);
        unset($_SESSION['success']); // clear after reading

        $enchereModel = new Encheres();
        $encheres_CP = $enchereModel->getLimitedAuctions(4, 'e.coup_coeur', 1);
        $encheres = $enchereModel->getLimitedAuctions(4, 'status', 1);
        return View::render('index', [
            'encheres_CP' => $encheres_CP,
            'encheres' => $encheres,
            'success' => $success,
            'errors' => $errors
        ]);
    }
}
