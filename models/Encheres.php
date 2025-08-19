<?php

namespace App\Models;

use App\Models\CRUD;

class Encheres extends CRUD
{
    protected $table = 'encheres';
    protected $primaryKey = 'id';
    protected $fillable = ['id_timbre', 'prix_depart'];

    public function getAllAuctionWithMainIMG()
    {
        $sql = "
            SELECT 
            e.id AS enchere_id,
            e.debut,
            e.fin,
            e.coup_coeur,
            e.prix_depart,

            t.id AS timbre_id,
            t.titre,
            t.description,
            t.annee,
            t.certifie,
            t.dimension,
            t.tirage,
            t.id_proprietaire,

            p.pays AS pays_nom,
            c.couleur AS couleur_nom,
            co.condition AS condition_nom,

            i.url_image AS image_principale,


            COALESCE(MAX(m.montant), e.prix_depart) AS prix_actuel 

        FROM encheres e
        INNER JOIN timbres t ON e.id_timbre = t.id
        LEFT JOIN images_timbre i ON t.id = i.id_timbre AND i.principale = 1
        LEFT JOIN pays p ON t.id_pays = p.id_pays
        LEFT JOIN couleur c ON t.id_couleur = c.id_couleur
        LEFT JOIN `condition` co ON t.id_condition = co.id_condition
        LEFT JOIN mises m ON e.id = m.id_enchere
        GROUP BY e.id
        ORDER BY e.debut DESC
        ";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
