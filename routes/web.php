<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('change-lang/{lang}', 'ChangeLangController@index')->name('chang.lang');

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/login','AuthenticatedSessionController@store');
Route::get('/logout','AuthenticatedSessionController@destroy')->name('logout');;

Route::get('/app', function () {
    $role = Auth::user()->role;
        session()->put('role',strtolower($role));
        if($role->id = 3){
            return redirect()->back()->with(['errors_' => [__('msg.access_deny')]]);
        }else{
            Route::get('/app/dashboard', 'admin\DashboardController@index')->name('dashboard');
        }
});


#Admin Panel
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified','Blade'])->group(function () {

    #Posts
    Route::get('posts-index', 'PostController@index')->name('posts-index');
    Route::get('posts-datatable', 'PostController@datatable')->name('post.datatable');
    Route::post('save-post/{id?}', 'PostController@save')->name('post.save');
    Route::get('post-edit/{id}', 'PostController@edit')->name('post.edit');
    Route::get('block-post/{id}', 'PostController@block')->name('post.block');
    Route::get('unblock-post/{id}', 'PostController@unblock')->name('post.unblock');
});
