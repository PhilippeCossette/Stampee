<?php

namespace App\Models;

use App\Models\CRUD;


class Encheres extends CRUD
{
    protected $table = 'encheres';
    protected $primaryKey = 'id';
    protected $fillable = ['id_timbre', 'prix_depart'];

    public function getLimitedAuctions($limit, $conditionColumn = null, $conditionValue = null)
    {
        $sql = "
            SELECT 
                e.id AS enchere_id,
                e.debut,
                e.fin,
                e.coup_coeur,
                e.prix_depart,
                e.status,

                t.id AS timbre_id,
                t.titre,
                t.description,
                t.annee,
                t.certifie,
                t.dimension,
                t.tirage,
                t.id_proprietaire,

                i.url_image

            FROM $this->table e
            INNER JOIN timbres t ON e.id_timbre = t.id
            LEFT JOIN images_timbre i ON t.id = i.id_timbre AND i.principale = 1
        ";

        if ($conditionColumn && $conditionValue) {
            $sql .= " WHERE $conditionColumn = :conditionValue";
        }

        $sql .= " ORDER BY RAND() LIMIT " . $limit;

        $stmt = $this->prepare($sql);
        if ($conditionColumn && $conditionValue) {
            $stmt->bindValue(':conditionValue', $conditionValue);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAuctionsWithFilters($filters = [])
    {
        $sql = "
            SELECT 
                e.id AS enchere_id,
                e.debut,
                e.fin,
                e.coup_coeur,
                e.prix_depart,
                e.status,

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

            FROM $this->table e
            INNER JOIN timbres t ON e.id_timbre = t.id
            LEFT JOIN images_timbre i ON t.id = i.id_timbre AND i.principale = 1
            LEFT JOIN pays p ON t.id_pays = p.id_pays
            LEFT JOIN couleur c ON t.id_couleur = c.id_couleur
            LEFT JOIN `condition` co ON t.id_condition = co.id_condition
            LEFT JOIN mises m ON e.id = m.id_enchere
            WHERE 1=1
        ";

        $params = [];

        // Filters
        if (!empty($filters['color'])) {
            $sql .= " AND t.id_couleur = :color";
            $params['color'] = $filters['color'];
        }

        if (!empty($filters['pays'])) {
            $sql .= " AND t.id_pays = :pays";
            $params['pays'] = $filters['pays'];
        }

        if (!empty($filters['condition'])) {
            $sql .= " AND t.id_condition = :condition";
            $params['condition'] = $filters['condition'];
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $sql .= " AND e.status = :status";
            $params['status'] = $filters['status'];
        }


        if (!empty($filters['year'])) {
            $sql .= " AND t.annee = :year";
            $params['year'] = $filters['year'];
        }

        if (!empty($filters['certified'])) {
            $sql .= " AND t.certifie = :certified";
            $params['certified'] = $filters['certified'];
        }

        if (!empty($filters['coup_coeur'])) {
            $sql .= " AND e.coup_coeur = :coup_coeur";
            $params['coup_coeur'] = $filters['coup_coeur'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND t.titre LIKE :search";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= " GROUP BY e.id ORDER BY e.debut DESC";

        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getFilterOptions()
    {
        // Colors
        $stmt = $this->prepare("
            SELECT DISTINCT c.id_couleur, c.couleur 
            FROM timbres t
            INNER JOIN couleur c ON t.id_couleur = c.id_couleur
            ORDER BY c.couleur ASC
        ");
        $stmt->execute();
        $colors = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Pays
        $stmt = $this->prepare("
            SELECT DISTINCT p.id_pays, p.pays 
            FROM timbres t
            INNER JOIN pays p ON t.id_pays = p.id_pays
            ORDER BY p.pays ASC
        ");
        $stmt->execute();
        $pays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Conditions
        $stmt = $this->prepare("
            SELECT DISTINCT co.id_condition, co.condition 
            FROM timbres t
            INNER JOIN `condition` co ON t.id_condition = co.id_condition
            ORDER BY co.condition ASC
        ");
        $stmt->execute();
        $conditions = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Years
        $stmt = $this->prepare("SELECT DISTINCT annee FROM timbres ORDER BY annee DESC");
        $stmt->execute();
        $years = $stmt->fetchAll(\PDO::FETCH_COLUMN); // Gives [2024, 2025, 2055] instead of [['annee'=>2024],['annee'=>2025],['annee'=>2055]]


        return [
            'colors' => $colors,
            'conditions' => $conditions,
            'years' => $years,
            'pays' => $pays
        ];
    }

    public function updateStatus()
    {
        $sql = "UPDATE $this->table
                SET status = 0
                WHERE fin < NOW() AND status = 1";
        $stmt = $this->prepare($sql);
        $stmt->execute();
    }

    public function getAuctionById($id)
    {
        $sql = "
        SELECT 
            e.id AS enchere_id,
            e.debut,
            e.fin,
            e.prix_depart,
            e.coup_coeur,
            e.status,

            t.id AS timbre_id,
            t.titre,
            t.description,
            t.annee,
            t.certifie,
            t.dimension,
            t.id_proprietaire,

            u.nom_utilisateur AS proprietaire_nom, -- Nom du propriétaire
            c.condition,
            col.couleur,
            p.pays,

            COALESCE(MAX(m.montant), e.prix_depart) AS prix_actuel,
            COUNT(DISTINCT f.id_utilisateur) AS favoris_count -- Nombre unique de personnes ayant mis en favoris
            
        FROM $this->table e
        INNER JOIN timbres t ON e.id_timbre = t.id
        LEFT JOIN utilisateur u ON t.id_proprietaire = u.id
        LEFT JOIN `condition` c ON t.id_condition = c.id_condition
        LEFT JOIN couleur col ON t.id_couleur = col.id_couleur
        LEFT JOIN pays p ON t.id_pays = p.id_pays
        LEFT JOIN mises m ON e.id = m.id_enchere
        LEFT JOIN favoris f ON e.id = f.id_enchere
        WHERE e.id = :id
        GROUP BY e.id
        LIMIT 1
    ";

        $stmt = $this->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function isFavori($idUser, $idEnchere)
    {
        $sql = "
        SELECT COUNT(*) 
        FROM favoris 
        WHERE id_utilisateur = :user AND id_enchere = :enchere
        ";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':user', $idUser, \PDO::PARAM_INT);
        $stmt->bindValue(':enchere', $idEnchere, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result['COUNT(*)'] > 0;
    }

    public function getMyAuction($idUser, $limit = null)
    {
        $sql = "
        SELECT 
            e.id AS enchere_id,
            e.fin,
            e.coup_coeur,
            e.prix_depart,
            e.status,

            t.id AS timbre_id,
            t.titre,
            t.certifie,
            

            i.url_image AS image_principale,
            COALESCE(MAX(m.montant), e.prix_depart) AS prix_actuel

        FROM {$this->table} e
        INNER JOIN timbres t ON e.id_timbre = t.id
        LEFT JOIN images_timbre i ON t.id = i.id_timbre AND i.principale = 1
        LEFT JOIN mises m ON e.id = m.id_enchere
        WHERE t.id_proprietaire = :idUser
        GROUP BY e.id
        ORDER BY e.fin DESC
        ";

        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':idUser', $idUser, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
