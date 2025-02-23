@extends('layouts.myapp')
@section('content')
<link rel="stylesheet" href="/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="/assets/compiled/css/table-datatable-jquery.css">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">     
                    <h5 class="card-title">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Mes projets</span>
                            <a href="{{ route('projets.create') }}" class="btn btn-success">Créer un nouveau projet</a>
                        </div>
                    </h5>
                </div>
                <div class="card-body">
                @if (session('addUserError'))
                    <div class="alert alert-warning">
                        {{ session('addUserError') }}
                    </div>
                @endif
                @if (session('addUserSuccess'))
                    <div class="alert alert-success">
                        {{ session('addUserSuccess') }}
                    </div>
                @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Titre</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col" class="text-center">Date de début</th>
                                <th scope="col" class="text-center">Date de fin</th>
                                <th scope="col" class="text-center">Participants</th>
                                <th scope="col" class="text-center">Statut</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($projets)
                            @foreach($projets as $projet)
                            <tr>
                                <td>{{ $projet->titre }}</td>
                                <td>{{ $projet->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($projet->date_debut)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
                                <td>{{ \Carbon\Carbon::parse($projet->date_fin)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                  @foreach ($projet->users as $user)
                                    <div>
                                       <span>{{ $user->name }} </span>

                                           <!-- Formulaire de modification du rôle -->
                                    @if($projet->users()->where('user_id', auth()->id())->first()->pivot->role == 'admin')
                                      <form action="{{ route('projets.updateMemberRole', ['id' => $projet->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                         @method('PUT')
                                         <input type="hidden" name="email" value="{{ $user->email }}">
                                       <select name="role" class="form-select form-select-sm d-inline" style="width:125px " onchange="this.form.submit()">
                                         <option value="membre" {{ $user->pivot->role == 'membre' ? 'selected' : '' }}>Collaborateur</option>
                                         <option value="admin" {{ $user->pivot->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                       </select>
                                       </form>

                                     <!-- Formulaire de suppression du membre -->
                                     <form action="{{ route('projets.deleteMember', ['id' => $projet->id]) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        @method('DELETE')
                                         <input type="hidden" name="email" value="{{ $user->email }}">
                                       <button type="submit" class="btn btn-sm btn-danger"data-bs-toggle="tooltip" onclick="return confirm('Êtes-vous sûr de vouloir retirer ce participant du projet ?')" title="Retirer">
                                      <i class="bi bi-person-dash-fill"></i>
                                       </button>
                                     </form>
                                  @else
                                  <span class="me-2">({{ $user->pivot->role }})</span>                
                                    @endif
                                     </div>
                                     <br>
                                 @endforeach
                                </td>

                                <td>{{ $projet->statut }}</td>
                                <td>
                                    <a href="{{route('taches.index',$projet)}}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Tâches">
                                        <i class="bi bi-list-task"></i>
                                    </a>
                                    @if($projet->users()->where('user_id', auth()->id())->first()->pivot->role == 'admin')
                                    <a href="{{ route('projets.edit', $projet) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Modifier">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button class="btn btn-sm btn-secondary add-member-btn" data-bs-toggle="tooltip" data-bs-target="#addMemberModal" data-projet-id="{{ $projet->id }}" title="Nouveau membre">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </button>
                                    <form action="{{ url('/projets/'.$projet->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce projet ?')" data-bs-toggle="tooltip" title="Supprimer">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">Aucun projet trouvé. Créez votre premier projet!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout de membre -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Ajouter un membre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMemberForm" method="POST">
                    @csrf
                    <input type="hidden" id="projet_id" name="projet_id">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="membre">Collaborateur</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/static/js/pages/datatables.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Récupérer le modal Bootstrap
    var addMemberModal = new bootstrap.Modal(document.getElementById('addMemberModal'));

    // Sélectionner tous les boutons "Ajouter un membre"
    document.querySelectorAll(".add-member-btn").forEach(button => {
        button.addEventListener("click", function () {
            let projetId = this.getAttribute("data-projet-id");
            let form = document.getElementById("addMemberForm");

            // Met à jour l'action du formulaire avec l'ID du projet
            form.action = "/projets/" + projetId + "/addMember"; 
            
            // Ajoute l'ID du projet dans le champ caché
            document.getElementById("projet_id").value = projetId;

            // Ouvre le modal via JavaScript
            addMemberModal.show();
        });
    });

    // Ferme automatiquement le modal après soumission du formulaire
    document.getElementById("addMemberForm").addEventListener("submit", function () {
        setTimeout(() => {
            addMemberModal.hide();
        }, 500);
    });
});

</script>
@endsection
