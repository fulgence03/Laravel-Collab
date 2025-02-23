<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    /** @use HasFactory<\Database\Factories\ProjetFactory> */
    use HasFactory;
    protected $fillable = ['titre', 'description', 'date_debut', 'date_fin', 'statut'];

    /**
     * Get the users associated with the project.
     */ 
    public function users()   
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }    
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
