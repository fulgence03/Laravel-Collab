<?php

namespace App\Http\Controllers;

use App\Models\Fichier;
use App\Http\Requests\StoreFichierRequest;
use App\Http\Requests\UpdateFichierRequest;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FichierController extends Controller
{
    /**
     * Affiche la liste des fichiers d'une tâche.
     */
    public function index(Tache $tache)
    {
        $fichiers = $tache->fichiers;
        return view('fichiers.index', compact('fichiers', 'tache'));
    }

    /**
     * Affiche le formulaire d'ajout de fichier pour une tâche.
     */
    public function create(Tache $tache)
    {
        return view('fichiers.create', compact('tache'));
    }
    
    /**
     * Stocke les fichiers uploadés.
     */
    public function store(StoreFichierRequest $request, Tache $tache)
    {
        if (!$request->hasFile('fichiers')) {
            return redirect()->back()->with('error', 'Aucun fichier sélectionné.');
        }

        foreach ($request->file('fichiers') as $file) {
            $nomComplet = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nomSansExtension = pathinfo($nomComplet, PATHINFO_FILENAME); // Enlève l'extension

            $fichier = new Fichier();
            $fichier->nom = $nomSansExtension;
            $fichier->extension = $extension;
            $fichier->taille = $file->getSize();
            $fichier->tache_id = $tache->id;
            $fichier->chemin = $file->store('fichiers', 'public'); // Stocké dans `storage/app/public/fichiers`
            $fichier->save();
        }

        return redirect()->route('fichiers.index', $tache)->with('success', 'Fichiers ajoutés avec succès.');
    }

    /**
     * Télécharge un fichier.
     */
    public function update(UpdateFichierRequest $request, Tache $tache, Fichier $fichier)
    {
        $fichier->nom = $request->nom;
        $fichier->save();

        return redirect()->back()->with('success', 'Nom du fichier modifié.');
    }
    public function download(Tache $tache, Fichier $fichier)
    {
        $filePath = storage_path("app/public/{$fichier->chemin}");
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Le fichier n\'existe pas.');
        }

        return response()->download($filePath, $fichier->nom . '.' . $fichier->extension);
    }

    /**
     * Supprime un fichier.
     */
    public function destroy(Tache $tache, Fichier $fichier)
    {
        if (Storage::disk('public')->exists($fichier->chemin)) {
            Storage::disk('public')->delete($fichier->chemin);
        }

        $fichier->delete();
        return redirect()->back()->with('success', 'Fichier supprimé.');
    }
}
