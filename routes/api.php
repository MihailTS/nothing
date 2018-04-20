<?php

use Illuminate\Http\Request;

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
Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'v1/posts',
    'as' => 'post.',
], function () {
    Route::get('/', ['as' => 'all', 'uses' => 'PostController@all']);
    Route::get('/{post}', ['as' => 'one', 'uses' => 'PostController@one']);
});