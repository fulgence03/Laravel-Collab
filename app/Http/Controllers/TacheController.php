<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use App\Http\Requests\StoretacheRequest;
use App\Http\Requests\UpdatetacheRequest;
use App\Models\Projet;
use App\Mail\TacheAssignationMail;
use Illuminate\Support\Facades\Mail; 
use App\Models\User;
class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index (Projet $projet)
    {

        $taches = $projet->taches->sortByDesc('date_echeance');
        return view('taches.index', compact( 'taches', 'projet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Projet $projet)
    {
        //
        
        return view('taches.create', compact('projet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTacheRequest $request, Projet $projet)
    {
        $tache = new Tache();
        $tache->titre = $request->titre;
        $tache->description = $request->description;
        $tache->date_echeance = $request->date_echeance;
        $tache->projet_id = $request->projet_id;
        $tache->save();

        if ($request->has('members')) {
            $tache->users()->sync($request->members);
            
            foreach ($request->members as $memberId) {
                $user = User::find($memberId);
                if ($user) {
                    Mail::to($user->email)->send(new TacheAssignationMail($tache, $user->first()));
                }
            }
        }

        return redirect()->route('taches.index', $request->projet_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(tache $tache)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tache $tache)
    {
        //
        
        return view('taches.edit', compact('tache'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTacheRequest $request, Tache $tache)
    {
        $tache->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'date_echeance' => $request->date_echeance,
            'statut' => $request->statut,
            'projet_id' => $request->projet_id
        ]);

        if ($request->has('members')) {
            $anciensMembres = $tache->users->pluck('id')->toArray();
            $tache->users()->sync($request->members);
            $nouveauxMembres = array_diff($request->members, $anciensMembres);
            foreach ($nouveauxMembres as $memberId) {
                $user = User::find($memberId);
                if ($user) {
                    Mail::to($user->email)->send(new TacheAssignationMail($tache, $user->first()));
                }
            }

        } else {
            $tache->users()->sync([]);
        }

        if ($tache->projet->taches->where('statut', 'en cours')->count() > 0) {
            $tache->projet->update(['statut' => 'en cours']);
        }

        return redirect()->route('taches.index', $tache->projet_id)->with('success', 'Tâche mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projet $projet, Tache $tache)
    {
        
        $tache->delete();
        return redirect()->route('taches.index', $projet->id);
    }
}
