<?php

namespace App\Models;

use App\Models\CRUD;

class Mises extends CRUD
{
    protected $table = 'mises';
    protected $primaryKey = 'id';
    protected $fillable = ['montant'];

    public function placeBid($idEnchere, $idUser, $montant)
    {
        $sql = "
            SELECT prix_depart, fin, status
                FROM encheres
                WHERE id = :id AND status = 1
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $idEnchere, PDO::PARAM_INT);
        $stmt->execute();
        $enchere = $stmt->fetch();

        if (!$enchere || new \DateTime() > new \DateTime($enchere['fin'])) {
            return [
                'success' => false,
                'message' => "Auction is not active."
            ];
        }

        $sql = "
            SELECT MAX(montant) as max_mise 
                FROM mises 
                WHERE id_enchere = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $idEnchere, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $min = $row['max_mise'] ? $row['max_mise'] : $enchere['prix_depart'];

        if ($montant <= $min) {
            return [
                'success' => false,
                'message' => "Bid must be higher than current highest."
            ];
        }

        // Insérer la mise
        $sql = "
                INSERT INTO mises (id_enchere, id_utilisateur, montant, date_heure)
            VALUES (:enchere, :user, :montant, NOW())
            ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchere', $idEnchere, PDO::PARAM_INT);
        $stmt->bindValue(':user', $idUser, PDO::PARAM_INT);
        $stmt->bindValue(':montant', $montant, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => "Bid placed successfully."
            ];
        }

        return [
            'success' => false,
            'message' => "Database error: could not place bid."
        ];
    }

    public function getCurrentPrice($idEnchere)
    {
        $sql = "
        SELECT MAX(montant) as max_mise 
        FROM mises 
        WHERE id_enchere = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $idEnchere, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row && $row['max_mise']) {
            return $row['max_mise']; // highest bid
        }

        // No bid yet, fetch starting price
        $sql = "
        SELECT prix_depart 
        FROM encheres 
        WHERE id = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $idEnchere, PDO::PARAM_INT);
        $stmt->execute();
        $enchere = $stmt->fetch();

        return $enchere['prix_depart'] ?? 0;
    }
}
