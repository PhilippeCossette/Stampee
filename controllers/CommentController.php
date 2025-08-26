<?php

namespace App\Controllers;

use App\Models\Timbres;
use App\Models\Mises;
use App\Models\Commentaire;
use App\Models\Encheres;

use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Validator;

class CommentController
{
    public function createComment()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $enchereId = $_POST['id_enchere'] ?? null;
        $contenu = trim($_POST['comment'] ?? '');

        if (!$userId || !$enchereId || empty($contenu)) {
            View::redirect('auctionlist');
            return;
        }

        $commentaireModel = new Commentaire();
        $commentaireModel->addComment($userId, $enchereId, $contenu);

        View::redirect("/auction?id={$enchereId}");
    }
}
