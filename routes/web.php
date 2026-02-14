<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CopyController as AdminCopyController;
use App\Http\Controllers\Admin\LoanManagementController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// ─── Authenticated routes ────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (vue principale 2 colonnes)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Catalogue (accessible à tous les utilisateurs connectés)
    Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalogue.index');
    Route::get('/catalogue/{book}', [CatalogController::class, 'show'])->name('catalogue.show');

    // Mes Emprunts (chaque utilisateur voit ses propres emprunts)
    Route::get('/mes-emprunts', [LoanController::class, 'index'])->name('loans.index');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin only routes (livres, exemplaires, utilisateurs) ──────
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Gestion des livres (admin seul)
    Route::resource('books', AdminBookController::class)->except(['show']);

    // Gestion des exemplaires (admin seul)
    Route::resource('copies', AdminCopyController::class)->except(['show']);

    // Gestion des utilisateurs (admin seul)
    Route::resource('users', AdminUserController::class)->except(['show']);

    // Paramètres (admin seul)
    Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});

// ─── Admin + Bibliothécaire routes (emprunts) ───────────────────
Route::middleware(['auth', 'verified', 'role:admin,bibliothecaire'])->prefix('admin')->name('admin.')->group(function () {

    // Gestion des emprunts
    Route::get('/loans', [LoanManagementController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanManagementController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanManagementController::class, 'store'])->name('loans.store');
    Route::patch('/loans/{loan}/return', [LoanManagementController::class, 'returnLoan'])->name('loans.return');
});

require __DIR__.'/auth.php';
