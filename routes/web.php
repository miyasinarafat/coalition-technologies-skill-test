<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Projects
    Route::get('dashboard', [ProjectController::class, 'index'])->name('dashboard');
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('{project}', [ProjectController::class, 'destroy'])->name('delete');
    });

    // Tasks
    Route::prefix('projects/{project}/tasks')->name('projects.tasks.')->group(function () {
        Route::get('/{task?}', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::post('lists', [TaskController::class, 'listStore'])->name('list.store');
        Route::delete('lists/{list}', [TaskController::class, 'listDestroy'])->name('list.delete');
        Route::get('{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('{task}', [TaskController::class, 'update'])->name('update');
        Route::put('{task}/move', [TaskController::class, 'move'])->name('move');
        Route::delete('{list}/{task}', [TaskController::class, 'destroy'])->name('delete');
    });
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::fallback(function () {
    return redirect()
        ->route('dashboard');
});

require __DIR__.'/auth.php';
