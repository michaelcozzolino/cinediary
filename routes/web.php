<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiariesController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\searchController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SettingsController;
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

Route::get('/language/{language}', function ($language) {

    if(in_array($language, config('app.available_locales'))){
        session(['locale' => $language]);

        if(Auth::user())
            Auth::user()->settings()->update(['defaultLanguage' => $language]);

    }

    return redirect()->back();
})->name('language');

Route::get('/', function () {

    if(! Auth::user())
        return Inertia::render('Home/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);

    return redirect()->route('dashboard');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'diaries.empty'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function(){

    Route::group(['prefix' => 'search'], function(){
        Route::get('/create', [SearchController::class, 'create'])->name('search.create');
        Route::post('/make', [SearchController::class, 'make'])->name('search.make');
        Route::get('/', [SearchController::class, 'index'])->name('search.index');
    });

    Route::group(['prefix' => 'settings'], function (){
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::patch('/', [SettingsController::class, 'update'])->name('settings.update');
    });

    Route::group(['prefix' => 'diaries'], function(){
        Route::get('/', [DiariesController::class, 'index'])->name('diaries.index');
        Route::post('store', [DiariesController::class, 'store'])->name('diaries.store');

    });


    Route::group(['prefix' => 'diaries/{diary}'], function (){

        Route::delete('/', [DiariesController::class, 'destroy'])->name('diaries.destroy');

        Route::group(['prefix' => 'movies'], function(){
            Route::get('/', [MoviesController::class, 'index'])->name('diaries.movies.index');
            Route::post('/', [MoviesController::class, 'store'])->name('diaries.movies.store');
            Route::delete('{movie}', [MoviesController::class, 'destroy'])->name('diaries.movies.destroy');
        });

        Route::group(['prefix' => 'series'], function(){
            Route::get('/', [SeriesController::class, 'index'])->name('diaries.series.index');
            Route::post('/', [SeriesController::class, 'store'])->name('diaries.series.store');
            Route::delete('/', [SeriesController::class, 'destroy'])->name('diaries.series.destroy');
        });



    });
    /* TODO: show routes can be showed if not logged by covering the auth components */
    Route::get('/movies/{movie}', [MoviesController::class, 'show'])->name('movies.show');
    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
});

require __DIR__.'/auth.php';
