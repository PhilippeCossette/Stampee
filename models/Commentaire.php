<?php

namespace App\Models;

use App\Models\CRUD;

class Commentaire extends CRUD
{
    protected $table = 'commentaire';
    protected $primaryKey = 'id';
    protected $fillable = ['contenu', 'date_heure', 'id_utilisateur', 'id_enchere'];

    
}
