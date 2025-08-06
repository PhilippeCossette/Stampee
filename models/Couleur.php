<?php
namespace App\Models;
use App\Models\CRUD;

class Couleur extends CRUD {
    protected $table = 'couleur';
    protected $primaryKey = 'id_couleur';
}