<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckProjectMember;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $projets = auth()->user()->projets()->latest()->take(10)->get();
    $en_cours = auth()->user()->projets()->where('statut', 'en cours')->count();
    $termine = auth()->user()->projets()->where('statut', 'terminé')->count();
    $en_attente = auth()->user()->projets()->where('statut', 'en attente')->count();
    return view('mydashboard', compact('projets', 'en_cours', 'termine', 'en_attente'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('projets', 'App\Http\Controllers\ProjetController');
    Route::post('projets/{projet}/addMember', 'App\Http\Controllers\ProjetController@addMember')->name('projets.addMember');
    Route::put('/projets/{id}/updateMemberRole', ['App\Http\Controllers\ProjetController'::class, 'updateMemberRole'])->name('projets.updateMemberRole');
    Route::delete('/projets/{id}/removeMember', ['App\Http\Controllers\ProjetController'::class, 'deleteMember'])->name('projets.deleteMember');
Route::middleware(checkProjectMember::class)->group(function () {    
    Route::get('/projets/{projet}/taches', ['App\Http\Controllers\TacheController'::class, 'index'])->name('taches.index');
    Route::get('/projets/{projet}/taches/create', ['App\Http\Controllers\TacheController'::class, 'create'])->name('taches.create');
    Route::post('/projets/{projet}/taches', ['App\Http\Controllers\TacheController'::class, 'store'])->name('taches.store');
    Route::get('/projets/taches/{tache}/edit', ['App\Http\Controllers\TacheController'::class, 'edit'])->name('taches.edit');
    Route::put('/projets/taches/{tache}', ['App\Http\Controllers\TacheController'::class, 'update'])->name('taches.update');
    Route::delete('/projets/{projet}/taches/{tache}', ['App\Http\Controllers\TacheController'::class, 'destroy'])->name('taches.destroy');
    Route::get('/projets/taches/{tache}/fichiers', ['App\Http\Controllers\FichierController'::class, 'index'])->name('fichiers.index');
    Route::post('/projets/taches/{tache}/fichiers', ['App\Http\Controllers\FichierController'::class, 'store'])->name('fichiers.store');
    Route::put('/projets/taches/{tache}/fichiers/{fichier}', ['App\Http\Controllers\FichierController'::class, 'update'])->name('fichiers.update');
    Route::get('/projets/taches/{tache}/fichiers/{fichier}/download', ['App\Http\Controllers\FichierController'::class, 'download'])->name('fichiers.download');
    Route::delete('/projets/taches/{tache}/fichiers/{fichier}', ['App\Http\Controllers\FichierController'::class, 'destroy'])->name('fichiers.destroy');

});
Route::get('/lang/french.json', function () {
    return response()->file(public_path('lang/french.json'));
});
});

require __DIR__.'/auth.php';
