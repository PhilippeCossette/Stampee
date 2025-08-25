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

    public function addFavorite($idUser, $idEnchere){
        $sql = "
        INSERT INTO {$this->table} (id_utilisateur, id_enchere)
        VALUES (:id_utilisateur, :id_enchere)
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $idUser, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $idEnchere, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
