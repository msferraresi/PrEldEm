<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaycheckController;
use App\Http\Controllers\RrhhController;

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
    //NOTICE Cotroller
    Route::resource('news', NewsController::class);

    //PAYCHECK Controller
    Route::post('paychecks.index', [PaycheckController::class, 'index'])->name('paychecks.index');
    Route::post('paychecks.show', [PaycheckController::class, 'show'])->name('paychecks.show');
    Route::resource('paychecks', PaycheckController::class, ['except' => ['index','show']]);

    //RRHH Controller Gral
    Route::resource('rrhh', RrhhController::class);
    //RRHH Controller NOTICES
    Route::post('/rrhh.index_news', [RrhhController::class, 'index_news'])->name('rrhh.index_news');
    Route::post('/rrhh.create_news', [RrhhController::class, 'create_news'])->name('rrhh.create_news');
    Route::post('/rrhh.store_news', [RrhhController::class, 'store_news'])->name('rrhh.store_news');
    Route::post('/rrhh.edit_news', [RrhhController::class, 'edit_news'])->name('rrhh.edit_news');
    Route::post('/rrhh.update_news', [RrhhController::class, 'update_news'])->name('rrhh.update_news');
    Route::post('/rrhh.destroy_news', [RrhhController::class, 'destroy_news'])->name('rrhh.destroy_news');
    //RRHH Controller GROUPS
    Route::post('/rrhh.index_group', [RrhhController::class, 'index_group'])->name('rrhh.index_group');
    Route::post('/rrhh.create_group', [RrhhController::class, 'create_group'])->name('rrhh.create_group');
    Route::post('/rrhh.store_group', [RrhhController::class, 'store_group'])->name('rrhh.store_group');
    Route::post('/rrhh.edit_group', [RrhhController::class, 'edit_group'])->name('rrhh.edit_group');
    Route::post('/rrhh.update_group', [RrhhController::class, 'update_group'])->name('rrhh.update_group');
    Route::post('/rrhh.destroy_group', [RrhhController::class, 'destroy_group'])->name('rrhh.destroy_group');
    //RRHH Controller ACTIVITY
    Route::get('/rrhh.index_activities', [RrhhController::class, 'index_activities'])->name('rrhh.index_activities');
    //RRHH Controller PAYCHECKS
    Route::get('/rrhh.index_paychecks', [RrhhController::class, 'index_paychecks'])->name('rrhh.index_paychecks');
    //RRHH Controller DOCUMENTS
    Route::get('/rrhh.index_documents', [RrhhController::class, 'index_documents'])->name('rrhh.index_documents');



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
    //Route::get('/rrhh', [NewsController::class, 'index'])->name('rrhh');
    Route::get('/administracion', [NewsController::class, 'index'])->name('administracion');
});
