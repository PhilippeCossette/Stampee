<?php

namespace App\Controllers;

use App\Models\Encheres;
use App\Models\Mises;


use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class BidController
{
    public function showBid()
    {
        Auth::session();

        $idUser = $_SESSION['user_id'];
        $idEnchere = $_GET['id_enchere'] ?? null;
        if (!$idEnchere) {
            View::redirect('auctionlist');
            return;
        }

        $enchereModel = new Encheres();
        $auction = $enchereModel->getAuctionById($idEnchere);

        $errors = $_SESSION['errors'] ?? null;
        $inputs = $_SESSION['inputs'] ?? null;
        unset($_SESSION['errors'], $_SESSION['inputs']);

        $misesModel = new Mises();
        $highestBidder = $misesModel->isHighestBidder($idEnchere, $idUser);

        return View::render('bid', [
            'auction' => $auction,
            'errors' => $errors,
            'inputs' => $inputs,
            'highestBidder' => $highestBidder
        ]);
    }

    public function showMyBidLog()
    {
        Auth::session();

        $enchereModel = new Encheres();
        $enchereModel->updateStatus();



        $misesModel = new Mises();
        $mesMises = $misesModel->getMyBidLog($_SESSION['user_id']);

        return View::render('myBidLog', ['mesMises' => $mesMises]);
    }

    public function storeBid()
    {
        Auth::session();

        $idUser = $_SESSION['user_id'];
        $idEnchere = $_POST['id_enchere'];
        $montant = $_POST['montant'];

        // Refetch to keep the idEnchere
        $enchereModel = new Encheres();
        $auction = $enchereModel->getAuctionById($idEnchere);

        $misesModel = new Mises();
        $currentHighest = $misesModel->getCurrentPrice($idEnchere);

        $validator = new Validator();
        $validator->field('montant', $montant)
            ->required()
            ->number()
            ->higherThan($currentHighest);

        if (!$validator->isSuccess()) {
            $_SESSION['errors'] = $validator->getErrors();
            $_SESSION['inputs'] = $_POST;
            return View::redirect('bid?id_enchere=' . $idEnchere);
        }

        $result = $misesModel->placeBid($idEnchere, $idUser, $montant);

        if ($result['success']) {
            $_SESSION['success'] = "Votre mise a été placée avec succès !";
            //redirect to auction page
            return View::redirect('auction?id=' . $idEnchere);
        } else {
            //return error message to view
            return View::render('error', [
                'message' => $result['message']
            ]);
        }
    }
}
