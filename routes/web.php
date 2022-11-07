<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
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

Route::get('/', function () {
    return view('auth.login');
})->name('home');

/*Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified', 'team'])->group(function () {
    Route::get('/novedades', function () {
        return view('news.index');
    })->name('novedades');
});*/

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified', 'team'])->group(function () {
    //Route::get('/novedades', NewsController::class)->name('novedades');
    //Route::get('/novedades', 'NewsController@index')->name('novedades');
    Route::resource('news', NewsController::class);

    //Route::get('/news', [NewsController::class, 'index'])->name('news');
    //Route::get('/news.create', [NewsController::class, 'create'])->name('news.create');
    //Route::get('/news.show', [NewsController::class, 'show'])->name('news.show');
    //Route::get('/news.edit', [NewsController::class, 'edit'])->name('news.edit');

    //Route::delete('/news.show', [NewsController::class, 'show'])->name('news.show');








    Route::get('/recibos', [NewsController::class, 'index'])->name('recibos');
    Route::get('/documentacion', [NewsController::class, 'index'])->name('documentacion');
    Route::get('/licencias', [NewsController::class, 'index'])->name('licencias');
    Route::get('/rrhh', [NewsController::class, 'index'])->name('rrhh');
    Route::get('/administracion', [NewsController::class, 'index'])->name('administracion');
});
