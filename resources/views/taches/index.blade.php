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
                        <li class="breadcrumb-item active" aria-current="page">{{$projet->titre}}</li>
                    </ol>
                </nav>   
                    <h5 class="card-title">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Tâches</span>
                            @if($projet->users()->where('user_id', auth()->id())->first()->pivot->role == 'admin' )
                            <a href="{{ route('taches.create', $projet->id) }}" class="btn btn-success">Ajouter une tâche</a>
                            @endif
                        </div>
                    </h5>
                </div>
                <div class="table-responsive">
                <table class="table table-lg">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Titre</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col" class="text-center">Echéance</th>
                                <th scope="col" class="text-center">Participants</th>
                                <th scope="col" class="text-center">Statut</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($taches->count() > 0)
                            @foreach($taches as $tache)
                            <tr>
                                <td>{{ $tache->titre }}</td>
                                <td>{{ $tache->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($tache->date_echeance)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                  @foreach ($tache->users as $user)
                                    <div class="d-flex align-items-center">
                                       <span class="me-2">{{ $user->name }}</span><br>
                                    </div>
                                 @endforeach
                                </td>

                                <td>{{ $tache->statut }}</td>
                                <td>
                                    @if($tache->users->contains(auth()->user()))
                                    <a href="{{route('fichiers.index',$tache)  }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Fichiers">
                                        <i class="bi bi-file-earmark-fill"></i>
                                    </a>
                                    @endif
                                    @if($projet->users()->where('user_id', auth()->id())->first()->pivot->role == 'admin' )
                                    <a href="{{ route('taches.edit',$tache) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Modifier">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ url('/projets/'.$projet->id.'/taches/'.$tache->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette tâche ?')" data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">Aucune tâche ajoutée à ce projet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/static/js/pages/datatables.js"></script>
@endsection
