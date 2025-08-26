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
        $stmt->bindValue(':id', $idEnchere, \PDO::PARAM_INT);
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
        $stmt->bindValue(':id', $idEnchere, \PDO::PARAM_INT);
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
        $stmt->bindValue(':enchere', $idEnchere, \PDO::PARAM_INT);
        $stmt->bindValue(':user', $idUser, \PDO::PARAM_INT);
        $stmt->bindValue(':montant', $montant, \PDO::PARAM_STR);

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
        $stmt->bindValue(':id', $idEnchere, \PDO::PARAM_INT);
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
        $stmt->bindValue(':id', $idEnchere, \PDO::PARAM_INT);
        $stmt->execute();
        $enchere = $stmt->fetch();

        return $enchere['prix_depart'] ?? 0;
    }

    public function isHighestBidder($idEnchere, $idUser)
    {
        $sql = "
        SELECT id_utilisateur 
        FROM mises 
        WHERE id_enchere = :id 
        ORDER BY montant DESC 
        LIMIT 1
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $idEnchere, \PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();

        return $row && $row['id_utilisateur'] == $idUser;
    }

    public function getMyBidLog($idUser, $limit = null)
    {
        $sql = "
        SELECT 
            e.id AS enchere_id,
            e.fin,
            e.status,
            e.prix_depart,

            t.id AS timbre_id,
            t.titre,

            m.montant,
            m.date_heure,

            h.highest_bid
        FROM encheres e
        INNER JOIN timbres t ON e.id_timbre = t.id
            -- latest bid per auction by this user
        INNER JOIN mises m 
        ON e.id = m.id_enchere
        AND m.id_utilisateur = :userId
            -- highest bid per auction
        INNER JOIN (
            SELECT id_enchere, MAX(montant) AS highest_bid
            FROM mises
            GROUP BY id_enchere
            ) h ON e.id = h.id_enchere
        ORDER BY m.date_heure DESC
        ";

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':userId', $idUser, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getBidLogbyID($enchere_id)
    {
        $sql = "
        SELECT 
            e.id AS enchere_id,
            e.fin,
            e.status,
            e.prix_depart,

            t.id AS timbre_id,
            t.titre,

            m.id AS mise_id,
            m.montant,
            m.date_heure,

            u.id AS utilisateur_id,
            u.nom_utilisateur,

            MAX(m2.montant) AS highest_bid
        FROM encheres e
        INNER JOIN timbres t ON e.id_timbre = t.id
        INNER JOIN mises m ON e.id = m.id_enchere
        INNER JOIN utilisateurs u ON m.id_utilisateur = u.id
        LEFT JOIN mises m2 ON e.id = m2.id_enchere
        WHERE e.id = :enchere_id
        GROUP BY m.id
        ORDER BY m.date_heure DESC
        ";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchere_id', $enchere_id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
