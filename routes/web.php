<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransportsController;
use App\Http\Controllers\ParcelsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SupportClientController;
use App\Http\Controllers\VerifyEmailController;

use App\Http\Middleware\CheckActiveUser;  // Assurez-vous d'importer le middleware personnalisé

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Toutes les routes du code
|
*/

// Route pour la page d'accueil
Route::get('/', [WelcomeController::class, 'index'])->name('Welcome');
Route::get('/search-parcel', [WelcomeController::class, 'searchParcel'])->name('search.parcel');

// Routes d'authentification
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logoutForm'])->name('logout.form');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/validate-account', [AuthController::class, 'showValidationForm'])->name('validate.form');
Route::post('/validate-account', [AuthController::class, 'validateAccount'])->name('validate.account');

// Routes protégées par le middleware d'authentification et de vérification d'utilisateur actif
Route::middleware(['auth', 'active'])->group(function () {

    // Route pour le dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes des pages
    Route::get('/zone', [ZoneController::class, 'index'])->name('zone-list');
    Route::post('/zones', [ZoneController::class, 'store'])->name('zones.store');
    Route::delete('/zones/{id}', [ZoneController::class, 'destroy'])->name('zones.destroy');

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');

    // Routes pour la gestion des transports
    Route::get('/transports', [TransportsController::class, 'index'])->name('transports-list');
    Route::post('/transports', [TransportsController::class, 'store'])->name('transports.store');
    Route::delete('/transports/{id}', [TransportsController::class, 'destroy'])->name('transports.destroy');

    // Routes pour la gestion des colis
    Route::get('/parcels', [ParcelsController::class, 'index'])->name('parcels-list');
    Route::post('/parcels/store', [ParcelsController::class, 'store'])->name('parcels.store');
    Route::delete('/parcels/{id}', [ParcelsController::class, 'destroy'])->name('parcels.destroy');
    Route::post('/update-parcel-status', [ParcelsController::class, 'updateStatus'])->name('update.parcel.status');

    // Routes de gestion des utilisateurs
    Route::get('/users/managers', [UsersController::class, 'managers'])->name('users.managers');
    Route::get('/users/clients', [UsersController::class, 'clients'])->name('users.clients');
    Route::get('/users/drivers', [UsersController::class, 'drivers'])->name('users.drivers');
    Route::get('/users/byCompany', [UsersController::class, 'getByCompany'])->name('users.byCompany');

    // Routes des listes utilisateurs
    Route::get('/clients', [UsersController::class, 'clients'])->name('clients');
    Route::post('/clients/store', [UsersController::class, 'storeClient'])->name('clients.store');
    Route::delete('/clients/destroy/{id}', [UsersController::class, 'destroyClient'])->name('clients.destroy');

    Route::get('/managers', [UsersController::class, 'managers'])->name('managers');
    Route::post('/managers/store', [UsersController::class, 'storeManager'])->name('managers.store');
    Route::delete('/managers/destroy/{id}', [UsersController::class, 'destroyManager'])->name('managers.destroy');

    Route::get('/drivers', [UsersController::class, 'drivers'])->name('drivers');
    Route::post('/drivers/store', [UsersController::class, 'storeDriver'])->name('drivers.store');
    Route::delete('/drivers/destroy/{id}', [UsersController::class, 'destroyDriver'])->name('drivers.destroy');

    // Autres routes protégées
    Route::get('/get-clients-zones', [ParcelsController::class, 'getClientsZones'])->middleware('auth');

    // Gestion des abonnements
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

    // Générer PDF
    Route::get('/reporting', [ReportsController::class, 'pdfPage'])->name('reporting');
    Route::post('/reports/pdf', [ReportsController::class, 'downloadPdf'])->name('reports.pdf');

    // Support client service
    Route::get('/support', [SupportClientController::class, 'index'])->name('support.index');
    Route::post('/support/send', [SupportClientController::class, 'sendMessage'])->name('support.sendMessage');

});

// Vérification de l'email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])->name('verification.verify');

