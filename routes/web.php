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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'TestController@test');
Route::get('/index', 'TestController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'mailer/maillist'], function () {
    Route::resource('mail', 'MailListController')
        ->names('mailer.maillist')
        ->except('show');
    Route::get('fileimport', 'MailListController@importFromFile')->name('mailer.maillist.importfromfile');
    Route::delete('deleteall', 'MailListController@deleteAll')->name('mailer.maillist.deleteall');
    Route::get('siteimport', 'MailListController@importFromSite')->name('mailer.maillist.importfromsite');
    Route::post('importsavefile', 'MailListController@saveFromImportFile')->name('mailer.maillist.savefromimportfile');
    Route::post('importsavesite', 'MailListController@saveFromImportSite')->name('mailer.maillist.savefromimportsite');
});



