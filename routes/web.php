<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'sisfalta', 'middleware' => 'auth', 'as' => 'sisfalta.'], function (){
    Route::get('/', function (){
        return view('sisfaltas.index');
    })->name('index');
    Route::resource('alunos', 'Sisfaltas\AlunoController');
    Route::resource('cursos', 'Sisfaltas\CursoController')->except(['show']);
    Route::resource('faltas', 'Sisfaltas\FaltaController')->only(['index']);
    Route::post('/faltas/upload/arquivo', 'Sisfaltas\FaltaUploadController')->name('faltas.arquivo');
    Route::get('/faltas/enviar-emails', 'Sisfaltas\FaltaController@sendEmail')->name('faltas.enviar');
});
