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

        Route::post('/search/', [SongController::class, 'sortandsearch'])->name('song.sortandsearch');
        Route::post('/addtoplaylist/', [SongController::class, 'addtoplaylist'])->name('song.addtoplaylist');

        Route::get('/{id}', [SongController::class, 'show'])->whereNumber('id')->name('song.show');
        Route::post('/selectSong', [SongController::class, 'selectSong'])->name('song.selectSong');
    });

    Route::prefix('/genre')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('genre.index');
    });

    Route::prefix('/playlist')->group(function () {
        Route::get('/', [playlistController::class, 'create'])->name('playlist.create');
        Route::post('/', [playlistController::class, 'store'])->name('playlist.store');
        Route::get('/{id}', [playlistController::class, 'show'])->whereNumber('id')->name('playlist.show');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Auth::routes();

Route::get('/', function () {
    return view('auth/login');
});

if (Auth::guest()) { //when user is not logged in
    Route::fallback([FallbackController::class, 'fallback1']);
} else {
    Route::fallback([FallbackController::class, 'fallback2']);
}


