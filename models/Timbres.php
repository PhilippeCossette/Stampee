<?php

namespace App\Models;

use App\Models\CRUD;

class Timbres extends CRUD
{
    protected $table = 'timbres';
    protected $primaryKey = 'id';
    protected $fillable = [
        'titre',
        'description',
        'annee',
        'id_pays',
        'id_couleur',
        'id_condition',
        'certifie',
        'dimension',
        'tirage',
        'id_proprietaire'
    ];
}
