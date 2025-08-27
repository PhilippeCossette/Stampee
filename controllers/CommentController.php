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

        $validator = new Validator();
        $validator->field('comment', $contenu, 'Commentaire')->required()->min(2)->max(500);

        if (!$userId || !$enchereId || !$validator->isSuccess()) {
            $_SESSION['errors'] = "Une erreur est survenue lors de la création du commentaire.";
            View::redirect('auctionlist');
            return;
        }

        $commentaireModel = new Commentaire();
        $commentaireModel->addComment($userId, $enchereId, $contenu);

        $_SESSION['success'] = "Votre commentaire a été ajouté avec succès.";
        View::redirect("auction?id={$enchereId}");
    }

    public function deleteComment()
    {
        $enchereId = $_POST['auction_id'] ?? null;
        $commentId = $_POST['comment_id'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;

        if (!$commentId || !$userId) {
            $_SESSION['errors'] = "Une erreur est survenue lors de la suppression du commentaire.";
            View::redirect('auctionlist');
            return;
        }
        $commentaireModel = new Commentaire();
        $comment = $commentaireModel->getCommentById($commentId);

        if (!$comment || $comment['id_utilisateur'] !== $userId) {
            $_SESSION['errors'] = "Une erreur est survenue lors de la suppression du commentaire.";
            View::redirect('auctionlist');
            return;
        }

        $commentaireModel->deleteComment($commentId);
        $_SESSION['success'] = "Votre commentaire a été supprimé avec succès.";
        View::redirect("auction?id={$enchereId}");
    }
}
