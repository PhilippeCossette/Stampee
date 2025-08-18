<?php
namespace App\Models;
use App\Models\CRUD;

class Encheres extends CRUD {
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

                p.nom AS pays_nom,
                c.nom AS couleur_nom,
                co.nom AS condition_nom,

                i.url_image AS image_principale
            FROM {$this->table} e
            INNER JOIN timbres t ON e.id_timbre = t.id
            LEFT JOIN images_timbres i ON t.id = i.id_timbre AND i.principale = 1
            LEFT JOIN pays p ON t.id_pays = p.id
            LEFT JOIN couleurs c ON t.id_couleur = c.id
            LEFT JOIN conditions co ON t.id_condition = co.id
            ORDER BY e.debut DESC
        ";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}