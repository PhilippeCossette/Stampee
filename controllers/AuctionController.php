<?php

namespace App\Controllers;

use App\Models\Timbres;
use App\Models\Condition;
use App\Models\Mises;
use App\Models\Couleur;
use App\Models\Pays;
use App\Models\ImagesTimbre;
use App\Models\Encheres;

use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class AuctionController
{
    public function auctionList()
    {
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        $filters = [
            'color' => $_GET['color'] ?? null,
            'condition' => $_GET['condition'] ?? null,
            'year' => $_GET['year'] ?? null,
            'certified' => isset($_GET['certified']) ? 1 : null,
            'search' => $_GET['search'] ?? null,
            'pays' => $_GET['pays'] ?? null,
            'coup_coeur' => isset($_GET['coup_coeur']) ? 1 : null,
            'status' => $_GET['status'] ?? 1 // par défaut, on montre que les actives
        ];


        $encheres = $enchereModel->getAuctionsWithFilters($filters);
        $filterOptions = $enchereModel->getFilterOptions();

        return View::render('auctionList', [
            'encheres' => $encheres,
            'filters' => $filters,
            'filterOptions' => $filterOptions
        ]);
    }

    public function showAuction()
    {
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();


        $id = $_GET['id'] ?? null;
        if (!$id) {
            View::redirect('/auctionlist');
            return;
        }

        $auction = $enchereModel->getAuctionById($id);

        $miseModel = new Mises();
        $EnchereBids = $miseModel->getBidsByAuctionId($id, 5);

        $imagesModel = new ImagesTimbre();
        $images = $imagesModel->selectByTimbre($auction['timbre_id']);

        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']); // clear after reading

        // Check if auction is already favorite for current user
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $auction['isFavori'] = $enchereModel->isFavori($userId, $auction['enchere_id']);
        }

        if (!$auction) {
            return View::render('error', ['message' => 'Impossible de trouver l\'enchère']);
        }

        return View::render('auctionDetails', ['auction' => $auction, 'images' => $images, 'success' => $success, 'bids' => $EnchereBids]);
    }
}
