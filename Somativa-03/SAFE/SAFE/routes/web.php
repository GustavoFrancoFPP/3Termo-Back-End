<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\PortariaController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// ===== ROTAS PÚBLICAS =====

// Rota de boas-vindas
Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin' => redirect('/admin/dashboard'),
            'professor' => redirect('/professor/dashboard'),
            'portaria' => redirect('/portaria/dashboard'),
            default => redirect('/dashboard'),
        };
    }
    return view('welcome');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== ROTAS ADMIN =====
Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/create-authorization', [AdminController::class, 'createAuthorization'])->name('admin.create-authorization');
    Route::post('/authorizations', [AdminController::class, 'storeAuthorization'])->name('admin.store-authorization');
    Route::get('/authorizations', [AdminController::class, 'listAuthorizations'])->name('admin.list-authorizations');
    Route::get('/authorizations/{id}', [AdminController::class, 'viewAuthorization'])->name('admin.view-authorization');
});

// ===== ROTAS PROFESSOR =====
Route::prefix('professor')->middleware(['auth', 'checkRole:professor'])->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('professor.dashboard');
    Route::get('/authorizations', [ProfessorController::class, 'listAuthorizations'])->name('professor.list-authorizations');
    Route::get('/authorizations/{id}', [ProfessorController::class, 'viewAuthorization'])->name('professor.view-authorization');
    Route::post('/authorizations/{id}/approve', [ProfessorController::class, 'approveAuthorization'])->name('professor.approve-authorization');
    Route::post('/authorizations/{id}/reject', [ProfessorController::class, 'rejectAuthorization'])->name('professor.reject-authorization');
    Route::get('/students', [ProfessorController::class, 'students'])->name('professor.students');
});

// ===== ROTAS PORTARIA =====
Route::prefix('portaria')->middleware(['auth', 'checkRole:portaria'])->group(function () {
    Route::get('/dashboard', [PortariaController::class, 'dashboard'])->name('portaria.dashboard');
    Route::get('/validate', [PortariaController::class, 'validateForm'])->name('portaria.validate-form');
    Route::post('/validate-code', [PortariaController::class, 'validateByCode'])->name('portaria.validate-code');
    Route::post('/confirm/{id}', [PortariaController::class, 'confirmValidation'])->name('portaria.confirm-validation');
    Route::get('/validations', [PortariaController::class, 'listValidations'])->name('portaria.list-validations');
    Route::get('/validations/{id}', [PortariaController::class, 'viewValidation'])->name('portaria.view-validation');
});

// Dashboard principal (legado)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Rotas de Alunos (CRUD) - legado
Route::resource('students', StudentController::class);

// Rotas de Responsáveis (CRUD) - legado
Route::resource('guardians', GuardianController::class);

// Rotas de Autorizações - legado
Route::prefix('authorizations')->group(function () {
    Route::get('/', [AuthorizationController::class, 'index'])->name('authorizations.index');
    Route::get('/create', [AuthorizationController::class, 'create'])->name('authorizations.create');
    Route::get('/history', [AuthorizationController::class, 'history'])->name('authorizations.history');
    Route::post('/', [AuthorizationController::class, 'store'])->name('authorizations.store');
    Route::get('/{authorization}', [AuthorizationController::class, 'show'])->name('authorizations.show');
    Route::post('/{authorization}/authorize', [AuthorizationController::class, 'authorize'])->name('authorizations.authorize');
    Route::post('/{authorization}/reject', [AuthorizationController::class, 'reject'])->name('authorizations.reject');
    Route::post('/{authorization}/validate', [AuthorizationController::class, 'validate'])->name('authorizations.validate');
});

// Rotas de Notificações - legado
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/stats', [NotificationController::class, 'stats'])->name('notifications.stats');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
});

// API Routes para validação na portaria
Route::prefix('api')->group(function () {
    Route::get('/authorizations/code/{code}', [AuthorizationController::class, 'getByCode']);
    Route::post('/authorizations/{authorization}/validate', [AuthorizationController::class, 'validate']);
});
