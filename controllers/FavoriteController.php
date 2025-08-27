<?php

namespace App\Controllers;

use App\Models\Encheres;
use App\Models\Mises;
use App\Models\Favoris;


use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class FavoriteController
{
    // Add a favorite auction   
    public function addFavorite()
    {
        // prevent access if not logged in
        Auth::session();
        $userId = $_SESSION['user_id'];

        $data = json_decode(file_get_contents('php://input'), true); // Get JSON payload    
        $idEnchere = $data['id_enchere'] ?? null;

        if (!$idEnchere) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID enchère manquant']);
            exit; // <- prevents Twig/layout from rendering
        }

        // Add favorite
        $favoris = new Favoris();
        $success = $favoris->addFavorite($userId, $idEnchere);

        header('Content-Type: application/json'); // Set content type to JSON
        echo json_encode(['success' => true]);
        exit; // prevent any further output
    }

    // Remove a favorite auction
    public function removeFavorite()
    {
        // Prevent access if not logged in
        Auth::session();
        $userId = $_SESSION['user_id'];

        // Get JSON payload from fetch
        $data = json_decode(file_get_contents('php://input'), true);
        $idEnchere = $data['id_enchere'] ?? null;

        if (!$idEnchere) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID enchère manquant']);
            exit; // <- prevents Twig/layout from rendering
        }

        $favoris = new Favoris();
        $success = $favoris->removeFavorite($userId, $idEnchere);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit; // prevent any further output
    }
}
