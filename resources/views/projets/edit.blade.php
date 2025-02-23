@extends('layouts.myapp')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Projet</h4>
                        </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{route('projets.update', $projet)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="titre">Titre</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="text" id="titre" class="form-control" name="titre"
                                                placeholder="titre" value="{{old('titre', $projet->titre)}}">
                                                <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description">Description</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="text" id="description" class="form-control" name="description"
                                                placeholder="description" value="{{old('description', $projet->description)}}">
                                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="date_debut">Date de debut</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="date" id="date_debut" class="form-control" name="date_debut" value="{{old('date_debut', $projet->date_debut)}}" required>
                                            <x-input-error :messages="$errors->get('date_debut')" class="mt-2" />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="date_fin">Date de fin</label>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <input type="date" id="date_fin" class="form-control" name="date_fin" value="{{old('date_fin', $projet->date_fin)}}" required>
                                            <x-input-error :messages="$errors->get('date_fin')" class="mt-2" />
                                        </div>
                                        <fieldset class="form-group">
                                            <select name="statut" id="statut" class="form-select" required>
                                                <option value="en attente" {{ $projet->statut == 'en attente' ? 'selected' : '' }}>
                                                en attente</option>
                                                <option value="en cours" {{ $projet->statut == 'en cours' ? 'selected' : '' }}>
                                                en cours</option>
                                                <option value="terminé" {{ $projet->statut == 'terminé' ? 'selected' : '' }}>
                                                terminé</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                                        </fieldset>
                                          <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Modifier</button>
                                                <a href="{{route('projets.index')}}" class="btn btn-light-secondary me-1 mb-1">Annuler</a>
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