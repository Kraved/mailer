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
    Route::post('/import/save', 'MailListImportController@save')->name('maillist.import.save');
    Route::get('/import', 'MailListImportController@index')->name('maillist.import.index');
    Route::get('/export', 'MailListExportController@export')->name('maillist.export');
});;

Route::name('mailer.')->group(function () {
    Route::get('mailer/index', 'MailerController@index')->name('mailer.index');
    Route::post('mailer/send', 'MailerController@send')->name('mailer.send');
});