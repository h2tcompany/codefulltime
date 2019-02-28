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

Route::get('/{code}','PasteController@GetPaste');
Route::get('/a/{code}','PasteController@GetPasteA');

Route::get('/paste/all','PasteController@Pastes');

Route::post('/paste/edit-paste','PasteController@EditPaste');
Route::get('/paste/new-paste','PasteController@CreatePastePage');
Route::post('/paste/new-paste','PasteController@CreatePaste');


Route::get('/comment/add-new','CommentController@add');
