<?php
namespace App\Models;
use App\Models\CRUD;

class Utilisateur extends CRUD{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $fillable = ['nom_utilisateur', 'email', 'mot_de_passe'];
}