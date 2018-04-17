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
Route::get('/home_alumno', 'HomeController@index_alumno')->name('home_alumno');
Route::get('/storage/{root}/{archivo}', 'Funciones\FuncionesController@showFile')->name('callFile/');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');
//$this->post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => 'auth'], function () {

// Password Reset Routes...
/*
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/
    Route::get('edit', 'Auth\EditUserDataController@showEditUserData')->name('edit');
    Route::put('Edit', 'Auth\EditUserDataController@update')->name('Edit');
    Route::get('showEditProfilePhoto/', 'Auth\EditUserDataController@showEditProfilePhoto')->name('showEditProfilePhoto/');
    Route::get('showEditProfileEmail/', 'Auth\EditUserDataController@showEditProfileEmail')->name('showEditProfileEmail/');
    Route::put('changeEmailUser/', 'Auth\EditUserDataController@changeEmailUser')->name('changeEmailUser/');

    Route::post('subirFotoProfile/', 'Storage\StorageProfileController@subirArchivoProfile')->name('subirArchivoProfile/');
    Route::get('quitarFotoProfile/', 'Storage\StorageProfileController@quitarArchivoProfile')->name('quitarArchivoProfile/');





});

Route::get('/admin', function () {
    return view('/admin/dashboard');
})->name('dashboard')->middleware(['auth', 'admin']);
