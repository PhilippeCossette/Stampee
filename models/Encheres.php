<?php
namespace App\Models;
use App\Models\CRUD;

class Encheres extends CRUD {
    protected $table = 'encheres';
    protected $primaryKey = 'id';
    protected $fillable = ['id_timbre', 'prix_depart'];
}