<?php
namespace App\Models;
use App\Models\CRUD;

class ImagesTimbre extends CRUD {
    protected $table = 'images_timbre';
    protected $primaryKey = 'id';
    protected $fillable = ['id_timbres', 'url_image', 'principale'];
}