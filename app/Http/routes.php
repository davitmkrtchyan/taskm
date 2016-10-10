<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::auth();

Route::get('/task', 'HomeController@task');


Route::get('/chat', 'HomeController@chat');
Route::post('sendmessage', 'chatController@sendMessage');

Route::post('/create', 'HomeController@create');

Route::delete('/task/delete/{id}', 'HomeController@delete');


Route::get('/history', 'HomeController@history');

Route::delete('/history/clear', 'HomeController@clearHistory');

Route::post('/history/restore/{id}', 'HomeController@restoreHistory');

//Route::get('/home', 'HomeController@index');
