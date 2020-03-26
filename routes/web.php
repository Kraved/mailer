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
    return redirect(route('mailer.maillist.index'));
});

Route::get('/test', 'TestController@test');
Route::get('/index', 'TestController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'maillist'], function () {
    Route::resource('mail', 'MailListController')
        ->names('mailer.maillist')
        ->except('show');
    Route::delete('deleteall', 'MailListController@deleteAll')->name('mailer.maillist.deleteall');
    Route::get('/import/file', 'MailListImportController@importFromFile')->name('mailer.maillist.import.file');
    Route::get('/import/site', 'MailListImportController@importFromSite')->name('mailer.maillist.import.site');
    Route::post('/import/file/save', 'MailListImportController@importFromFileHandler')->name('mailer.maillist.import.file.handler');
    Route::post('/import/site/save', 'MailListImportController@importFromSiteHandler')->name('mailer.maillist.import.site.handler');
});
Route::get('mailer/index', 'MailerController@index')->name('mailer.mailer.index');
Route::post('mailer/send', 'MailerController@send')->name('mailer.mailer.send');

