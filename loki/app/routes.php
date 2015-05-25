<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@getHome'));
Route::get('/remove-pic-from-group', array('as' => 'remove_pic_from_group', 'uses' => 'HomeController@getRemovePicFromGroup'));
Route::get('/remove-group', array('as' => 'remove_group', 'uses' => 'HomeController@getRemoveGroup'));
Route::get('/add-pic-to-group', array('as' => 'add_pic_to_group', 'uses' => 'HomeController@getAddPicToGroup'));
Route::get('/create-group', array('as' => 'create_group', 'uses' => 'HomeController@getCreateGroup'));
Route::get('/delete-guy', array('as' => 'delete_guy', 'uses' => 'HomeController@getDeleteGuy'));
