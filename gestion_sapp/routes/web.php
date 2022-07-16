<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//Route::get('/personas',                               'AdminController@showPersonas');
//Route::get('/personas/{id}/editar',                   'AdminController@showPersonaEdit');
//Route::post('/personas',                              'AdminController@createPersona');
//Route::post('/personas/{cargo}/editar',               'AdminController@editPersona');
//Route::get('/personas/{cargo}/eliminar',              'AdminController@deletePersona');

//Route::get('/', function () {
//    return view('home');
//});
Auth::routes();

Route::get('/enviar_correo', 'App\Http\Controllers\AdminController@sendCorreo');
Route::get('/crearexcel', 'App\Http\Controllers\AdminController@crearExcel');

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::get('profile', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::get('informatica/crear', ['as' => 'informatica.crear', 'uses' => 'App\Http\Controllers\AdminController@showInformaticaCreate']);
    Route::get('informatica', ['as' => 'informatica', 'uses' => 'App\Http\Controllers\AdminController@showInformatica']);
    Route::get('informatica/{id}/editar', ['as' => 'informatica/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showInformaticaEdit']);
    Route::get('informatica/{id}/eliminar', ['as' => 'informatica/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deleteInformatica']);
    Route::post('informatica', ['as' => 'informatica', 'uses' => 'App\Http\Controllers\AdminController@createInformatica']);
    Route::get('tablasdelsistema', ['as' => 'tablasdelsistema', 'uses' => 'App\Http\Controllers\AdminController@showTabla']);
    Route::get('permisos/crear', ['as' => 'permisos.crear', 'uses' => 'App\Http\Controllers\AdminController@showPermisoCreate']);
    Route::post('permisos', ['as' => 'permisos', 'uses' => 'App\Http\Controllers\AdminController@createPermiso']);
    Route::get('informatica/ver', ['as' => 'informatica.ver', 'uses' => 'App\Http\Controllers\AdminController@verInformaticas']);
    Route::get('informatica/imprimir', ['as' => 'informatica.imprimir', 'uses' => 'App\Http\Controllers\AdminController@printInformaticas']);
    //	Route::get('informatica/imprimir/excel', ['as' => 'informatica.imprimir.excel', 'uses' => 'App\Http\Controllers\AdminController@crearExcel']);

});

///Auth::routes();

///Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
