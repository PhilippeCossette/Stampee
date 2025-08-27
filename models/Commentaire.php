<?php

namespace App\Models;

use App\Models\CRUD;

class Commentaire extends CRUD
{
    protected $table = 'commentaire';
    protected $primaryKey = 'id';
    protected $fillable = ['contenu', 'date_heure', 'id_utilisateur', 'id_enchere'];

    // Function to show comments for a specific auction
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
                ORDER BY c.date_heure DESC
        ";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchere_id', $id, \PDO::PARAM_INT); // Send value in integer format safer
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Fetch all comments in an associative array
    }

    // Function to add a comment   
    public function addComment($userId, $enchereId, $contenu)
    {
        $sql = "
                INSERT INTO {$this->table} (contenu, id_utilisateur, id_enchere) 
                VALUES (:contenu,:id_utilisateur, :id_enchere)
                ";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':contenu', $contenu, \PDO::PARAM_STR); // Bind content parameter tells that it's a string
        $stmt->bindValue(':id_utilisateur', $userId, \PDO::PARAM_INT); // Bind user ID parameter tells that it's an integer
        $stmt->bindValue(':id_enchere', $enchereId, \PDO::PARAM_INT); // Bind auction ID parameter tells that it's an integer

        return $stmt->execute();
    }

    // Function to get a comment by its ID
    public function getCommentById($id){
        $sql = "
        SELECT * 
        FROM {$this->table} 
        WHERE id = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT); // Bind comment ID parameter tells that it's an integer
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); // Fetch the comment in an associative array
    }

    public function deleteComment($id){
        $sql = "
        DELETE FROM {$this->table} 
        WHERE id = :id
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT); // Bind comment ID parameter tells that it's an integer
        return $stmt->execute();
    }
}
