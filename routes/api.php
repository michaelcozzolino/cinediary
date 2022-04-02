<?php

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\SeriesController;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/popular-movies', [MoviesController::class, 'indexPopular'])->name('popular-movies');
Route::get('/popular-series', [SeriesController::class, 'indexPopular'])->name('popular-series');

Route::get('/statistics', function () {
    $registeredUsers = User::all()->count();
    $createdDiaries = Diary::withoutGlobalScope('userDiaries')->count();
    $trackedMovies = Movie::all()->count();
    $trackedSeries = Series::all()->count();

    return compact('registeredUsers', 'createdDiaries', 'trackedMovies', 'trackedSeries');
})->name('statistics');

Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
