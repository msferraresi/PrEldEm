<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaycheckController;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified', 'team'])->group(function () {

    Route::resource('news', NewsController::class);

    Route::post('paychecks.index', [PaycheckController::class, 'index'])->name('paychecks.index');
    Route::post('paychecks.show', [PaycheckController::class, 'show'])->name('paychecks.show');
    Route::resource('paychecks', PaycheckController::class, ['except' => ['index','show']]);

    //Route::get('/paychecks/index/{id}', [PaycheckController::class, 'index'])->name('paychecks.index');
    //Route::get('/paychecks/{id}',[PaycheckController::class,'index'])->middleware('auth','user')->name('paychecks.index');
    /*Route::get('/paychecks?id={id}', function ($id) {
       dd($id);
    })->name('paychecks.index');
    Route::get('/paychecks.show', [PaycheckController::class, 'show'])->name('paychecks.show');*/
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
