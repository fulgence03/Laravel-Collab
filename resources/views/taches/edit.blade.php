@extends('layouts.myapp')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Modifier la Tâche</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" method="POST" action="{{ route('taches.update',$tache) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="titre">Titre</label>
                                </div>
                                <div class="col-md-10 form-group">
                                    <input type="text" id="titre" class="form-control" name="titre"
                                        value="{{ old('titre', $tache->titre) }}" required>
                                    <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                                </div>

                                <div class="col-md-4">
                                    <label for="description">Description</label>
                                </div>
                                <div class="col-md-10 form-group">
                                    <input type="text" id="description" class="form-control" name="description"
                                        value="{{ old('description', $tache->description) }}">
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div class="col-md-4">
                                    <label for="date_echeance">Échéance</label>
                                </div>
                                <div class="col-md-10 form-group">
                                    <input type="date" id="date_echeance" class="form-control" name="date_echeance"
                                        value="{{ old('date_echeance', $tache->date_echeance) }}" required>
                                    <x-input-error :messages="$errors->get('date_echeance')" class="mt-2" />
                                </div>

                                <input type="hidden" name="projet_id" value="{{ $tache->projet->id }}">

                                <div class="col-md-4">
                                    <label for="members">Membres</label>
                                </div>
                                <div class="col-md-10 form-group">
                                    <select id="members" class="choices form-select multiple-remove" name="members[]" multiple="multiple" lang="fr">
                                        @foreach($tache->projet->users as $user)
                                            <option value="{{ $user->id }}"
                                                @if($tache->users->contains($user)) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('members')" class="mt-2" />
                                </div>
                                <fieldset class="form-group">
                                            <select name="statut" id="statut" class="form-select" required>
                                                <option value="suspendue" {{ $tache->statut == 'suspendue' ? 'selected' : '' }}>
                                                suspendue</option>
                                                <option value="en cours" {{ $tache->statut == 'en cours' ? 'selected' : '' }}>
                                                en cours</option>
                                                <option value="terminée" {{ $tache->statut == 'terminée' ? 'selected' : '' }}>
                                                terminée</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                                        </fieldset>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Modifier</button>
                                    <a href="{{ route('taches.index', $tache->projet) }}" class="btn btn-light-secondary me-1 mb-1">Annuler</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
