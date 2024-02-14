<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

$router->get('/', function () use ($router) {
    return $router->app->version();
});
Route::group(['prefix' => 'api'], function() use ($router){
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::get('/user', 'AuthController@getUser');
    Route::put('/editUser/{id}', 'AuthController@editUser');

    //Blog Routes
    Route::post('/createBlog/', 'BlogController@createBlog');
    Route::put('/editBlog/{id}', 'BlogController@editBlog');
    Route::delete('/deleteBlog/{id}', 'BlogController@deleteBlog');
    Route::get('/getBlog', 'BlogController@getBlogs');





});
Route::get('/hello', 'Controller@hello');
Route::get('/getDetails', 'Controller@getData');






