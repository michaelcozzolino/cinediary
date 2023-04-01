<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\DiaryScreenplayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ScreenplayController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::put('/languages/{language}', [LanguageController::class, 'update'])->name('language.update');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->middleware(['diaries.empty'])
         ->name('dashboard');

    Route::group(['prefix' => 'search'], function () {
        Route::post('/make', [SearchController::class, 'make'])->name('search.make');
        Route::get('/', [SearchController::class, 'index'])->name('search.index');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [UserSettingsController::class, 'index'])->name('settings.index');
        Route::patch('/', [UserSettingsController::class, 'update'])->name('settings.update');
    });

    Route::group(['prefix' => 'diaries'], function () {
        Route::get('/', [DiaryController::class, 'index'])->name('diaries.index');
        Route::post('store', [DiaryController::class, 'store'])->name('diaries.store');
    });

    Route::group(['prefix' => 'diaries/{diary}'], function () {
        Route::delete('/', [DiaryController::class, 'destroy'])->name('diaries.destroy');

        Route::group(['prefix' => 'movies'], function () {
            Route::get('/', [DiaryScreenplayController::class, 'index'])->name('diaries.movies.index');
            Route::post('/', [DiaryScreenplayController::class, 'add'])->name('diaries.movies.add');
            Route::delete('{movie}', [DiaryScreenplayController::class, 'destroy'])->name('diaries.movies.destroy');
        });

        Route::group(['prefix' => 'series'], function () {
            Route::get('/', [DiaryScreenplayController::class, 'index'])->name('diaries.series.index');
            Route::post('/', [DiaryScreenplayController::class, 'add'])->name('diaries.series.add');
            Route::delete('/{series}', [DiaryScreenplayController::class, 'destroy'])->name('diaries.series.destroy');
        });
    });
});

Route::get('/movies/{movie}', [ScreenplayController::class, 'show'])->name('movies.show');

Route::get('/series/{series}', [ScreenplayController::class, 'show'])->name('series.show');

require __DIR__ . '/auth.php';
