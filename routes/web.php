<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\FallbackController;
use App\Http\Controllers\playlistController;

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

// Route::resource('JukeBox', JukeBoxController::class);

// Multiple HTTP verbs
// Route::match(['GET', 'POST'], 'JukeBox', [JukeBoxController::class, 'index']);
// Route::any('JukeBox', [JukeBoxController::class, 'index']);

// Return Vieuw
// Route::view('/', 'home', []);

Route::group(['middleware' => ['auth']], function() { // routes when user is logged in
    Route::prefix('/song')->group(function () {
        Route::get('/', [SongController::class, 'overviewAll'])->name('song.overviewAll');
        Route::get('/genre/{genreid}', [SongController::class, 'overview'])->whereNumber('genreid')->name('song.overview');

        // Route::post('/search/', [SongController::class, 'search'])->where('search', '/[a-z0-9 \'.]/i')->name('song.search');
        // Route::post('/sort/', [SongController::class, 'sort'])->name('song.sort');
        Route::post('/search/', [SongController::class, 'sortandsearch'])->name('song.sortandsearch');

        Route::get('/{id}', [SongController::class, 'show'])->whereNumber('id')->name('song.show');

        // POST
        // Route::get('/create', [SongController::class, 'create'])->name('song.create');
        // Route::post('/', [SongController::class, 'store'])->name('song.store');

        // PUT OR PATCH
        // Route::get('/edit/{id}', [SongController::class, 'edit'])->whereNumber('id')->name('song.edit');
        // Route::patch('/{id}', [SongController::class, 'update'])->whereNumber('id')->name('song.update');

        // DELETE
        // Route::delete('/{id}', [SongController::class, 'destroy'])->whereNumber('id')->name('song.destroy');
    });

    Route::prefix('/genre')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('genre.index');
        // Route::get('/{id}', [GenreController::class, 'show'])->whereNumber('id')->name('genre.show');

        // POST
        // Route::get('/create', [GenreController::class, 'create'])->name('genre.create');
        // Route::post('/', [GenreController::class, 'store'])->name('genre.store');

        // // PUT OR PATCH
        // Route::get('/edit/{id}', [GenreController::class, 'edit'])->whereNumber('id')->name('genre.edit');
        // Route::patch('/{id}', [GenreController::class, 'update'])->whereNumber('id')->name('genre.update');

        // // DELETE
        // Route::delete('/{id}', [GenreController::class, 'destroy'])->whereNumber('id')->name('genre.destroy');
    });

    Route::prefix('/playlist')->group(function () {
        Route::get('/', [playlistController::class, 'create'])->name('playlist.create');
        Route::post('/', [playlistController::class, 'store'])->name('playlist.store');
        // Route::get('/{id}', [GenreController::class, 'show'])->whereNumber('id')->name('genre.show');

        // POST
        // Route::get('/create', [GenreController::class, 'create'])->name('genre.create');
        // Route::post('/', [GenreController::class, 'store'])->name('genre.store');

        // // PUT OR PATCH
        // Route::get('/edit/{id}', [GenreController::class, 'edit'])->whereNumber('id')->name('genre.edit');
        // Route::patch('/{id}', [GenreController::class, 'update'])->whereNumber('id')->name('genre.update');

        // // DELETE
        // Route::delete('/{id}', [GenreController::class, 'destroy'])->whereNumber('id')->name('genre.destroy');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Auth::routes();

Route::get('/', function () {
    return view('auth/login');
});

Route::fallback(FallbackController::class);


