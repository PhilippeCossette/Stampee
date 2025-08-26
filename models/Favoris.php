<?php

namespace App\Models;

use App\Models\CRUD;

class Favoris extends CRUD
{
    protected $table = 'favoris';
    protected $primaryKey = ['id_utilisateur', 'id_enchere'];
    protected $fillable = ['id_utilisateur', 'id_enchere'];

    public function removeFavorite($idUser, $idEnchere)
    {
        $sql = "
        DELETE 
        FROM {$this->table} 
        WHERE id_utilisateur = :id_utilisateur AND id_enchere = :id_enchere
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $idUser, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $idEnchere, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addFavorite($idUser, $idEnchere)
    {
        $sql = "
        INSERT IGNORE INTO {$this->table} (id_utilisateur, id_enchere)
        VALUES (:id_utilisateur, :id_enchere)
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $idUser, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $idEnchere, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getFavByUserId($userId, $limit = null)
    {
        $sql = "
        SELECT 
            e.id AS enchere_id,
            e.fin,
            e.prix_depart,
            e.coup_coeur,
            e.status,

            t.id AS timbre_id,
            t.titre,

            t.certifie,
            i.url_image AS image_principale,

            COALESCE(MAX(m.montant), e.prix_depart) AS prix_actuel
            
        FROM encheres e
        INNER JOIN timbres t ON e.id_timbre = t.id
        INNER JOIN {$this->table} f ON e.id = f.id_enchere
        LEFT JOIN images_timbre i ON t.id = i.id_timbre AND i.principale = 1
        LEFT JOIN mises m ON e.id = m.id_enchere
        WHERE f.id_utilisateur = :userId
        GROUP BY e.id
        ORDER BY e.fin DESC
    ";
        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
