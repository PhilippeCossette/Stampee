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

        $filters = [
            'color' => $_GET['color'] ?? null,
            'condition' => $_GET['condition'] ?? null,
            'year' => $_GET['year'] ?? null,
            'certified' => isset($_GET['certified']) ? 1 : null,
            'search' => $_GET['search'] ?? null
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
