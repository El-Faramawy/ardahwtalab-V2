<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::group(['namespace' => 'Api', 'prefix' => 'api', 'middleware' => 'api'], function () {
    Route::post('refresh_token', 'UserController@refresh_token');
    Route::get('homeapp', 'HomeController@index');
    Route::get('commision', 'HomeController@commision');
    Route::post('commision', 'HomeController@commision_store');
    Route::get('pay_methods', 'HomeController@pay_methods');
    Route::post('BankTransfer', 'HomeController@BankTransfer');
    Route::any('page', 'IndexController@page');
    //auth
    Route::any('login', 'UserController@login');
    Route::any('forget', 'UserController@forget');
    Route::any('signup', 'UserController@signup');
    Route::any('last/{type?}', 'AdvsController@last');
    Route::any('advertise', 'AdvsController@getInfo');
    //statics
    Route::any('contactus', 'IndexController@contactus');
    Route::any('country', 'IndexController@country');
    Route::any('area', 'IndexController@area');
    Route::any('cats', 'IndexController@cats');
    Route::any('cats/{id}/advs', 'IndexController@cats_advs');
    Route::any('types', 'IndexController@types');
    Route::any('props', 'IndexController@props');
    Route::any('joins', 'IndexController@joins');
    Route::any('banking', 'IndexController@banking');
    //search
    Route::any('search_form', 'SearchControl@details');
    Route::any('search', 'SearchControl@search');
    //user
    Route::any('user', 'UserController@getInfo');
    //pages
    Route::any('pages', 'IndexController@pages');
    Route::any('blacklist', 'IndexController@blacklist');

    // Route::any('saloka', 'AdvsController@saloka');


    //authed actions
    Route::group(['middleware' => 'api:auth'], function () {
        //advertise
        Route::any('advertise/create', 'AdvsController@create');
        Route::any('advertise/{ad}/delete', 'AdvsController@delete');
        Route::post('advertise/{ad}/delete_image', 'AdvsController@deleteImage');
        Route::any('advertise/{ad}/update', 'AdvsController@update');
        Route::any('advertise/{ad}/republished', 'AdvsController@republished');
        Route::any('{action?}/advertise', 'AdvsController@actions');
        Route::any('chat', 'IndexController@chat');
        Route::any('create_event', 'IndexController@create_event');
        //process
        Route::any('transfer', 'IndexController@transfer');
        //user
        Route::any('{action?}/user', 'UserController@actions');
        Route::any('user/notfs', 'UserController@notfs');
        Route::get('user/notfs/check', 'UserController@notfsCheck');
        Route::any('user/msgs', 'UserController@msgs');
        Route::any('user/followers', 'UserController@followers');
        Route::any('user/favourites', 'UserController@favors');

        // new
        Route::get('user/check/notifcation_chat_reed', 'UserController@notfsCheck');
        Route::get('user/read/{type?}', 'UserController@notfsType');

        Route::get('user/favourites/{user_id}', 'UserController@allfav');
        Route::get('user/favourites/{user_id}/{adv_id}/insert', 'UserController@insert_fav');
        Route::get('user/favourites/{user_id}/{adv_id}/delete', 'UserController@delete_fav');

        Route::get('user/rate/{user_id}/', 'UserController@allrate');
        Route::post('user/rate/{user_id}/', 'UserController@addrate');

        Route::any('lawsuits', 'LawsuitController@mylawsuits');
        Route::get('lawsuit/{id}', 'LawsuitController@show');
        Route::post('lawsuit/create', 'LawsuitController@create');
        Route::post('lawsuit/pay', 'LawsuitController@pay');
    });
    Route::group(['middleware' => 'api:lawyer'], function () {
        Route::get('lawyer/lawsuits', 'LawyerController@lawsuits');
        Route::get('lawsuit/{id}/accept', 'LawyerController@accept');
        Route::get('lawsuit/{id}/reject', 'LawyerController@reject');
    });
    Route::get('lawyer/signup', 'LawyerController@signup');
    Route::get('lawyer/login', 'LawyerController@login');
    Route::get('lawsuits_categories', 'LawsuitController@categories');
    Route::get('lawyer/{token}', 'LawyerController@show');
    Route::get('lawyer/{id}/byid', 'LawyerController@showByid');

    Route::get('lawsuit_txt', 'LawsuitController@txt');


    Route::get('payment/{user}/user/{id}/lawsuits', 'LawsuitController@payment');
    Route::get('payment_callback', 'LawsuitController@payment_callback');

    Route::get('lawsuit_lawyer/{id}', 'LawsuitController@lawsuit_lawyer')->where('id','[0-9]+');

    Route::get('lawyer/{lawyer_id}/lawsuit/{lawsuit_id}/choose', 'LawsuitController@lawyer_choose')->where('id','[0-9]+');
});*/
