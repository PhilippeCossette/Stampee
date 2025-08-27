<?php

namespace App\Controllers;

use App\Models\Encheres;
use App\Models\Mises;


use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class BidController
{   
    // Display Bid
    public function showBid()
    {
        Auth::session();

        $idUser = $_SESSION['user_id'];
        $idEnchere = $_GET['id_enchere'] ?? null;

        // Check if id is valid
        if (!$idEnchere) {
            View::redirect('auctionlist');
            return;
        }

        // Fetch auction details by ID
        $enchereModel = new Encheres();
        $auction = $enchereModel->getAuctionById($idEnchere);

        // Read session messages
        $errors = $_SESSION['errors'] ?? null;
        $inputs = $_SESSION['inputs'] ?? null;
        // Unset After
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

    // Display log of bid
    public function showMyBidLog()
    {
        // Prevent access if not logged in
        Auth::session();

        // Update auction status
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();



        $misesModel = new Mises();
        $mesMises = $misesModel->getMyBidLog($_SESSION['user_id']);

        return View::render('myBidLog', ['mesMises' => $mesMises]);
    }

    // Display auction bids
    public function showAuctionBids()
    {
        // Check if id is valid
        $idEnchere = $_GET['id'] ?? null;
        if (!$idEnchere) {
            View::redirect('auctionlist');
            return;
        }

        // Update auction status
        $enchereModel = new Encheres();
        $enchereModel->updateStatus();

        $misesModel = new Mises();
        $bids = $misesModel->getBidLogbyID($idEnchere);

        return View::render('auctionBids', [
            'bids' => $bids,
            'enchere_id' => $idEnchere
        ]);
    }

    // Store a new bid
    public function storeBid()
    {
        // Prevent access if not logged in
        Auth::session();

        // Get user input   
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
            //Check if bid is the highest amount
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
            $_SESSION['errors'] = [$result['message']];
            return View::redirect('auction?id=' . $idEnchere);
        }
    }
}
