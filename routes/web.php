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

Route::view('/', 'welcome')->name('beranda');
Route::get('/b/{slug}', 'UmumController@get_broadcast')->name('broadcast');

Route::group(['middleware' => ['guest']], function () {

    Route::get('/login', 'UmumController@get_login')->name('login');
    Route::post('/login', 'UmumController@post_login')->name('login.post');
    Route::get('/signup', 'UmumController@get_signup')->name('signup');
    Route::post('/signup', 'UmumController@post_signup');
    Route::get('/verifikasi', 'UmumController@get_verifikasi')->name('signup.verify');
    Route::get('/reset_pass', function(){ return view('reset_pass'); })->name('reset_pass');
    Route::post('/reset_pass', 'UmumController@post_reset');
    Route::any('/reset_pass/{code}', 'UmumController@gantisandi')->name('reset_pass.go');

});

Route::group(['middleware' => ['auth']], function () {
    
    Route::group(['prefix' => 'user', 'middleware' => ['role:user']], function () {
        Route::redirect('/', '/user/beranda');
        Route::get('/beranda', 'UserController@get_beranda')->name('user.beranda');
        Route::view('/info', 'user.info')->name('user.info');
        Route::group(['prefix' => '/pesan/buat', 'as' => 'user.pesan.create'], function(){
            Route::get('/', 'UserController@get_buatpesan');
            Route::post('/', 'UserController@post_buatpesan');
        });
        Route::get('pesan/{pesan}/view', 'UserController@get_pesan')->name('user.pesan.view');

        Route::get('/curhatan/{id}', 'UserController@get_pesan')->name('user.pesan');
        Route::post('/curhatan/{id}', 'UserController@post_pesan');
        Route::post('/curhatan/{id}/jawab', 'UserController@post_read_pesan')->name('user.pesan.jawab');
        
    });
    
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        Route::redirect('/', '/admin/beranda');
        Route::get('/beranda', 'AdminController@get_beranda')->name('admin.beranda');

        Route::get('/curhatan/{id}', 'AdminController@get_pesan')->name('admin.pesan');
        Route::post('/curhatan/{id}', 'AdminController@post_pesan');

        Route::get('/ranting', 'AdminController@get_ranting')->name('admin.ranting');
        Route::post('/ranting', 'AdminController@post_ranting');

        Route::view('sysinfo', 'admin.sysinfo')->name('admin.sysinfo');
        Route::get('users', 'AdminController@get_users')->name('admin.users');
        Route::post('users/down/{id}', 'AdminController@post_usersdown')->name('admin.users.down');
        Route::post('users/up/{id}', 'AdminController@post_usersup')->name('admin.users.up');

        Route::post('jabatan', 'AdminController@post_jabatan')->name('admin.jabatan');
        Route::get('broadcast', 'AdminController@get_broadcast')->name('admin.broadcast');
        Route::post('broadcast', 'AdminController@post_broadcast');

    });

    Route::post('/logout', 'UmumController@logout')->name('logout');

});