@extends('layouts.myapp')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('projets.index')}}">Mes projets</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('taches.index',$tache->projet) }}"> {{$tache->projet->titre}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Fichiers</li>
                    </ol>
                </nav>   
                    <h5 class="card-title text-center">Fichiers</h5>
                    <div class="d-flex justify-content-end">
                        @if($tache->users->contains(auth()->user()))
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">Ajouter un fichier</button>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-lg text-center">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Taille</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($fichiers->count() > 0)
                            @foreach($fichiers as $fichier)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <form action="{{ route('fichiers.update', [$tache, $fichier]) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="nom" value="{{ $fichier->nom }}" class="form-control text-center" required @if(!$tache->users->contains(auth()->user())) disabled @endif>
                                            @if($tache->users->contains(auth()->user()))
                                            <button type="submit" class="btn btn-sm btn-warning ms-2" data-bs-toggle="tooltip" title="Modifier">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                                <td>{{ number_format($fichier->taille / 1024, 2) }} Ko</td>
                                <td>
                                @if($tache->users->contains(auth()->user()))
                                    <a href="{{ route('fichiers.download', [$tache, $fichier]) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Télécharger">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('fichiers.destroy', [$tache, $fichier]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce fichier ?')" data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">Aucun fichier trouvé.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour l'upload de fichiers -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Ajouter un fichier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('fichiers.store', $tache) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="fichiers[]" class="multiple-files-filepond" multiple>
                            <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/./assets/static/js/pages/filepond.js"></script>
<script src="/./assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="/./assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
<script src="/./assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
<script src="/./assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="/./assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
<script src="/./assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="/./assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
<script src="/./assets/extensions/filepond/filepond.js"></script>
@endsection
