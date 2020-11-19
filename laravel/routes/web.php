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

    Route::get('/', [
        'uses' => 'App\Http\Controllers\Controller@index',
        'as' => 'welcome'
    ]);

    Route::get('/message/{id}' , [
        'uses' => 'App\Http\Controllers\Controller@getMessage',
        'as' => 'message'
    ]);
    
    Route::post('/message' , [
        'uses' => 'App\Http\Controllers\Controller@postSendMessage',
        'as' => 'message'
    ]);

    Route::get('/Profile',[
        'uses' => 'App\Http\Controllers\UserController@getUserProfile',
        'as' => 'profile',
        'middleware' => 'auth'
    ]);
    
    Route::get('/sign-up', function () {
        return view('sign-up');
    })->name('sign-up');
    
    Route::post('/signup', [
        'uses' => 'App\Http\Controllers\UserController@postSignUp',
        'as' => 'signup'
    ]);

    Route::get('/sign-in', function () {
        return view('sign-in');
    })->name('sign-in');
    
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
        'as' => 'account',
        'middleware' => 'auth'

    ]);

    Route::post('/updateaccount' , [
        'uses' => 'App\Http\Controllers\UserController@postSaveAccount',
        'as' => 'account.save'    
    ]);

    Route::get('/userimage/{filename}' ,[
        'uses' => 'App\Http\Controllers\UserController@getUserImage',
        'as' => 'account.image'
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
    
    Route::post('/post-view/{post_id}' ,[
        'uses' => 'App\Http\Controllers\PostController@getPostView'
    ])->name('post.view');;
    
    Route::get('/post-delete/{post_id}',[
        'uses' => 'App\Http\Controllers\PostController@getDeletePost',
        'as' => 'post.delete',
        'middleware' => 'auth'
    ]);
    
    Route::get('edit-post/{post_id}' ,[
        'uses' => 'App\Http\Controllers\PostController@getEditPost',
        'as' => 'editPosts',
        'middleware' => 'auth'  
    ]);

    Route::post('/post-edit' ,[
        'uses' => 'App\Http\Controllers\PostController@postEditPost',
        'as' => 'edit-post',
        'middleware' => 'auth'
    ]);

    Route::get('/postimage/{filename}' ,[
        'uses' => 'App\Http\Controllers\PostController@getPostImage',
        'as' => 'post.image'
    ]);
    Route::post('/like' ,[
        'uses' => 'App\Http\Controllers\PostController@postLikePost',
        'as' => 'like'
    ]);

    Route::post('/comment' ,[
        'uses' => 'App\Http\Controllers\PostController@postCommentPost',
        'as' => 'comment',
        'middleware' => 'auth'
    ]);
});