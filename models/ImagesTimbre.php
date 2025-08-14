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
}
