@extends ('layouts.myapp')
@section('content')
            
<div class="page-heading">
    <h3>Statistiques</h3>
</div> 
<div class="page-content">
    <section class="row">
        <div class="row">
            <!-- Statistiques des projets -->
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                        <h5 class="card-title mt-3">Projets Réalisés</h5>
                        <h3 class="fw-bold">{{ $termine }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                        <h5 class="card-title mt-3">Projets en Cours</h5>
                        <h3 class="fw-bold">{{ $en_cours }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-clock fs-1 text-danger"></i>
                        <h5 class="card-title mt-3">Projets en Attente</h5>
                        <h3 class="fw-bold">{{ $en_attente }}</h3>
                    </div>
                </div>
            </div>
        </div>
       @if($projets->count()>0)
        <!-- Liste des derniers projets -->
        <div class="row mt-4">
            <div class="col-12">
                <h4>Derniers Projets</h4>
                <div class="row">
                    @foreach ($projets as $projet)
                     <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">{{ $projet->titre }}</h5>
                                    <p class="card-text text-muted">{{ $projet->description }}</p>
                                    @php
                                        $progress = $projet->taches->count() > 0 ? ($projet->taches->where('statut', 'terminée')->count() * 100 / $projet->taches->count()) : 0;
                                    @endphp
                                    <div class="d-flex align-items-center" style="min-width: 310px;">
                                        <div class="progress" style="flex-grow: 1; min-height: 20px;">
                                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="ms-2">{{ round($progress) }}%</span>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn icon icon-left btn-info me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $projet->id }}" title="détails"><i class="bi bi-info-circle"></i></button>
                                    <button class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#tasksModal{{ $projet->id }}" title="tâches"><i class="bi bi-list-task"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Détails -->
                    <div class="modal fade" id="detailsModal{{ $projet->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $projet->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailsModalLabel{{ $projet->id }}">Détails du Projet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>{{ $projet->titre }}</h5>
                                    <ul>
                                        <li>Date de début: {{ \Carbon\Carbon::parse($projet->date_debut)->locale('fr')->isoFormat('D MMMM YYYY') }}</li>
                                        <li>Date de fin: {{ \Carbon\Carbon::parse($projet->date_fin)->locale('fr')->isoFormat('D MMMM YYYY') }}</li>
                                        <li>Statut: {{ $projet->statut }}</li>
                                        <li>Participants: 
                                            @foreach ($projet->users as $user)
                                                {{ $user->name }}@if (!$loop->last), @endif
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Tâches -->
                    <div class="modal fade" id="tasksModal{{ $projet->id }}" tabindex="-1" aria-labelledby="tasksModalLabel{{ $projet->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tasksModalLabel{{ $projet->id }}">Tâches du Projet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Titre</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Échéance</th>
                                                <th scope="col">Participants</th>
                                                <th scope="col">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($projet->taches->count() == 0)
                                                <tr>
                                                    <td colspan="5">Aucune tâche trouvée.</td>
                                                </tr>
                                            @else
                                            @foreach ($projet->taches as $tache)
                                                <tr>
                                                    <td>{{ $tache->titre }}</td>
                                                    <td>{{ $tache->description }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($tache->date_echeance)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
                                                    <td>
                                                        @foreach ($tache->users as $user)
                                                            {{ $user->name }}@if (!$loop->last), @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $tache->statut }}</td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </section>
</div>

<!-- Lien pour voir tous les projets -->
<div class="text-end mt-4">
    <a href="{{ route('projets.index') }}" class="text-decoration-none">Tous les projets</a>
</div>

@endsection