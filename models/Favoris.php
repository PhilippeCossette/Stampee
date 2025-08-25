<?php

namespace App\Models;

use App\Models\CRUD;

class Favoris extends CRUD
{
    protected $table = 'favoris';
    protected $primaryKey = ['id_enchere', 'id_user'];
    protected $fillable = ['id_enchere', 'id_user'];

    public function removeFavorite($idUser, $idEnchere)
    {
        $sql = "
        DELETE 
        FROM {$this->table} 
        WHERE id_user = :id_user AND id_enchere = :id_enchere
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_user', $idUser, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $idEnchere, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
