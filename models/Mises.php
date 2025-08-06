<?php
namespace App\Models;
use App\Models\CRUD;

class Mises extends CRUD {
    protected $table = 'mises';
    protected $primaryKey = 'id';
    protected $fillable = ['montant'];
}