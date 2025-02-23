<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projet;
use App\Models\User;
use App\Models\Fichier;
class tache extends Model
{
    /** @use HasFactory<\Database\Factories\TacheFactory> */
    use HasFactory;
    protected $fillable = ['titre', 'description', 'date_echeance', 'statut', 'projet_id'];
    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }
}
