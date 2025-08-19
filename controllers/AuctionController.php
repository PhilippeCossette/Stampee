<?php

namespace App\Controllers;

use App\Models\Timbres;
use App\Models\Condition;
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
            'color' => $_POST['color'] ?? null,
            'condition' => $_POST['condition'] ?? null,
            'year' => $_POST['year'] ?? null,
            'certified' => isset($_POST['certified']) ? 1 : null,
            'search' => $_POST['search'] ?? null,
            'pays' => $_POST['pays'] ?? null,
            'coup_coeur' => isset($_POST['coup_coeur']) ? 1 : null,
            'status' => $_POST['status'] ?? 1 // par défaut, on montre que les actives
        ];


        $encheres = $enchereModel->getAuctionsWithFilters($filters);
        $filterOptions = $enchereModel->getFilterOptions();

        return View::render('auctionList', [
            'encheres' => $encheres,
            'filters' => $filters,
            'filterOptions' => $filterOptions
        ]);
    }
}
