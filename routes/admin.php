<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 13/03/18
 * Time: 01:40 PM
 */

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::catch(function (){
    throw new NotFoundHttpException();
});

Route::get('/','DashboardController@index')->name('admin_dashboard');
Route::get('/events', function (){
    return 'Admin Events';
})->name('Admin_Events');
Route::post('/events/create',function (){
    return 'Event created!!';
});
Route::get('admin/', function(){
    return view('/admin/dashboard');
})->name('admin_dashboard')->middleware(['auth','admin']);

