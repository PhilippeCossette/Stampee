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

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':enchere_id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
