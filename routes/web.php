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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('mailer.maillist.index'));
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::name('mailer.')->prefix('maillist')->group(function () {
    Route::resource('mail', 'MailListController')
        ->names('maillist')
        ->except('show');
    Route::delete('deleteall', 'MailListController@deleteAll')->name('maillist.deleteall');
    Route::get('/import/file', 'MailListImportController@fileImport')->name('maillist.import.file');
    Route::get('/import/site', 'MailListImportController@siteImport')->name('maillist.import.site');
    Route::post('/import/file/save', 'MailListImportController@fileImportHandler')->name('maillist.import.file.handler');
    Route::post('/import/site/save', 'MailListImportController@siteImportHandler')->name('maillist.import.site.handler');
    Route::post('/import/site/save', 'MailListImportController@siteImportHandler')->name('maillist.import.site.handler');
    Route::get('/export', 'MailListExportController@export')->name('maillist.export');
});;

Route::name('mailer.')->group(function () {
    Route::get('mailer/index', 'MailerController@index')->name('mailer.index');
    Route::post('mailer/send', 'MailerController@send')->name('mailer.send');
});