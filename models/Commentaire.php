<?php

namespace App\Models;

use App\Models\CRUD;

class Commentaire extends CRUD
{
    protected $table = 'commentaire';
    protected $primaryKey = 'id';
    protected $fillable = ['contenu', 'date_heure', 'id_utilisateur', 'id_enchere'];

    public function showCommentaire($id)
    {
        $sql = "
            SELECT 
                c.id AS commentaire_id,
                c.contenu,
                c.date_heure,

                u.id AS utilisateur_id,
                u.nom_utilisateur,
                u.email
                
                FROM {$this->table} c
                INNER JOIN utilisateur u ON c.id_utilisateur = u.id
                WHERE c.id_enchere = :enchere_id
                ORDER BY c.date_heure ASC
        ";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchere_id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addComment($userId, $enchereId, $contenu)
    {
        $sql = "
                INSERT INTO {$this->table} (contenu, id_utilisateur, id_enchere) 
                VALUES (:contenu,:id_utilisateur, :id_enchere)
                ";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':contenu', $contenu, \PDO::PARAM_STR);
        $stmt->bindValue(':id_utilisateur', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $enchereId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Function to get a comment by its ID
    public function getCommentById($id){
        $sql = "
        SELECT * 
        FROM commentaire 
        WHERE id = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteComment($id){
        $sql = "
        DELETE FROM commentaire 
        WHERE id = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
