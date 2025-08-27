<?php

namespace App\Models;

use App\Models\CRUD;

class ImagesTimbre extends CRUD
{
    protected $table = 'images_timbre';
    protected $primaryKey = 'id';
    protected $fillable = ['id_timbre', 'url_image', 'principale'];

    public function selectByTimbre($timbreId)
    {
        $sql = "SELECT * FROM $this->table WHERE id_timbre = :id_timbre";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id_timbre", $timbreId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function selectMainByTimbre($id_timbre)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_timbre = :id_timbre AND principale = 1 LIMIT 1";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_timbre', $id_timbre);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function selectAdditionalByTimbre($id_timbre)
    {
        $sql = "SELECT COUNT(*) as total FROM images_timbre WHERE id_timbre = :timbreId AND principale = 0";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':timbreId', $id_timbre);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countImagesByTimbre($timbreId)
    {
        $sql = "SELECT COUNT(*) as total FROM images_timbre WHERE id_timbre = :timbreId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':timbreId', $timbreId, \PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $row['total'];
    }
}
