<?php

namespace App\Controllers;

use App\Models\Encheres;
use App\Models\Mises;


use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class BidController
{
    public function storeBid()
    {
        Auth::session();

        $idUser = $_SESSION['user']['id'];
        $idEnchere = $_POST['id_enchere'];
        $montant = $_POST['montant'];

        $misesModel = new Mises();
        $result = $misesModel->placeBid($idEnchere, $idUser, $montant);

        if ($result['success']) {
            //redirect to auction page with message
            return View::render('auctionDetails', [
                'success' => true,
                'message' => $result['message']
            ]);
        } else {
            //return error message to view
            return View::render('auctionDetails', [
                'success' => false,
                'message' => $result['message']
            ]);
        }
    }
}
