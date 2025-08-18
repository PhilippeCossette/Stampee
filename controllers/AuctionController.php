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

class AuctionController {
    public function auctionList() {
        $enchereModel = new Encheres();
        $encheres = $enchereModel->getAllEncheresWithStamps();

        return View::render('auctionlist', ['encheres' => $encheres]);
    }
}
