<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Http\Requests\StoreProjetRequest;
use App\Http\Requests\UpdateProjetRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\AjoutMembreMail;
use Illuminate\Support\Facades\Mail;
class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user=$request->user();
        $id =$user->id;
        $projets=Projet::whereHas('users', function($query) use ($id){
            $query->where('user_id', $id);
        })->get();
        return view('projets.index', compact('projets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('projets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjetRequest $request)
    {
        //
        $projet=new Projet();
        $projet->titre=$request->titre;
        $projet->description=$request->description;
        $projet->date_debut=$request->date_debut;
        $projet->date_fin=$request->date_fin;
        $projet->save();
        $user=$request->user();
        $projet->users()->attach($user->id, ['role' => 'admin']);
        return redirect()->route('projets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Projet $projet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projet $projet)
    {
        //
        return view('projets.edit', compact('projet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjetRequest $request, Projet $projet)
    {
        //
        $projet=Projet::find($projet->id);
        $projet->titre=$request->titre;
        $projet->description=$request->description;
        $projet->date_debut=$request->date_debut;
        $projet->date_fin=$request->date_fin;
        $projet->statut=$request->statut;
        $projet->save();
        return redirect()->route('projets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projet $projet)
    {
        //
        $projet->delete();
        return redirect()->route('projets.index');
    }

    public function addMember(Request $request, $id)
{
    
    $projet = Projet::findOrFail($id);

    // Récupérer l'utilisateur à ajouter
    $user = User::where('email', $request->email)->first();
    if(!$user){
        return redirect()->back()->with('addUserError', 'Utilisateur introuvable.');
    }
    // Vérifier si l'utilisateur est déjà dans le projet
    if ($projet->users()->where('user_id', $user->id)->exists()) {
        return redirect()->back()->with('addUserError', 'Ce participant fait déjà partie du projet.');
    }

    // Ajouter l'utilisateur au projet avec le rôle sélectionné
    $projet->users()->attach($user->id, ['role' => $request->role]);
    Mail::to($user->email)->send(new AjoutMembreMail($projet->first(), $user, $request->user()));


    return redirect()->back()->with('addUserSuccess', 'Participant ajouté avec succès au projet.');
}
public function updateMemberRole(Request $request, $id)
{
    $projet = Projet::findOrFail($id);
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->back()->with('addUserError', 'Utilisateur introuvable.');
    }

    // Vérifier si l'utilisateur est actuellement un admin
    $currentRole = $projet->users()->where('user_id', $user->id)->first()->pivot->role;

    // Si on veut changer un admin en "membre", vérifier qu'il reste au moins un autre admin
    if ($currentRole === 'admin' && $request->role !== 'admin') {
        $adminCount = $projet->users()->wherePivot('role', 'admin')->count();
        
        if ($adminCount <= 1) {
            return redirect()->back()->with('addUserError', 'Impossible de modifier ce rôle : il doit toujours y avoir au moins un administrateur.');
        }
    }

    // Modifier le rôle
    $projet->users()->syncWithoutDetaching([$user->id => ['role' => $request->role]]);

    return redirect()->back()->with('addUserSuccess', 'Le rôle du participant a été modifié avec succès.');
}

public function deleteMember(Request $request, $id)
{
    $projet = Projet::findOrFail($id);
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->back()->with('addUserError', 'Utilisateur introuvable.');
    }

    // Vérifier si l'utilisateur à supprimer est un admin
    $userRole = $projet->users()->where('user_id', $user->id)->first()->pivot->role;

    if ($userRole === 'admin') {
        $adminCount = $projet->users()->wherePivot('role', 'admin')->count();

        if ($adminCount <= 1) {
            return redirect()->back()->with('addUserError', 'Impossible de supprimer ce membre : il doit toujours y avoir au moins un administrateur.');
        }
    }

    // Supprimer l'utilisateur du projet
    $projet->users()->detach($user->id);

    return redirect()->back()->with('addUserSuccess', 'Le participant a été retiré avec succès du projet.');
}

}
