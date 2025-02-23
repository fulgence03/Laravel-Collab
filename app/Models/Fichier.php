<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tache;
class Fichier extends Model
{
    /** @use HasFactory<\Database\Factories\FichierFactory> */
    use HasFactory;
    protected $fillable = ['nom', 'chemin', 'extension', 'taille', 'tache_id'];
     
    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }
}
