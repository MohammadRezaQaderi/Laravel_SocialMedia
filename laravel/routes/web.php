<?php

use Illuminate\Support\Facades\Route;

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





Route::group(['middleware' => ['web']], function(){

    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    
    
    Route::post('/signup', [
        'uses' => 'App\Http\Controllers\UserController@postSignUp',
        'as' => 'signup'
    ]);

    Route::post('/signin', [
        'uses' => 'App\Http\Controllers\UserController@postSignIn',
        'as' => 'signin'
    ]);

    Route::get('/logout',[
        'uses' => 'App\Http\Controllers\UserController@getLogout',
        'as' => 'logout',
    ]);

    Route::get('/account' , [
        'uses' => 'App\Http\Controllers\UserController@getAccount',
        'as' => 'account'    
    ]);

    Route::post('/updateaccount' , [
        'uses' => 'App\Http\Controllers\UserController@postSaveAccount',
        'as' => 'account.save'    
    ]);

    Route::get('/userimage/{filename}' ,[
        'uses' => 'App\Http\Controllers\UserController@getUserImage',
        'as' => 'account.image'
    ]);

    Route::get('/postimage/{filename}' ,[
        'uses' => 'App\Http\Controllers\PostController@getPostImage',
        'as' => 'post.image'
    ]);

    Route::get('/dashboard', [
        'uses' => 'App\Http\Controllers\PostController@getDashboard',
        'as' => 'dashboard',
        'middleware' => 'auth'
    ]);

    Route::post('/createpost', [
        'uses' => 'App\Http\Controllers\PostController@postCreatePost',
        'as' => 'post.create',
        'middleware' => 'auth'
    ]);
    
    Route::get('/post-delete/{post_id}',[
        'uses' => 'App\Http\Controllers\PostController@getDeletePost',
        'as' => 'post.delete',
        'middleware' => 'auth'
    ]);

    Route::post('/edit' ,[
        'uses' => 'App\Http\Controllers\PostController@postEditPost',
        'as' => 'edit'
    ]);

    Route::post('/like' ,[
        'uses' => 'App\Http\Controllers\PostController@postLikePost',
        'as' => 'like'
    ]);
});