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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create')->middleware('must-be-confirmed');
Route::get('threads/search', 'SearchController@show');
Route::get('threads/{channel:slug}', 'ThreadController@index');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadController@update');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store')->middleware('must-be-confirmed');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');

Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::post('pinned-threads/{thread}', 'PinnedThreadsController@store')->name('pinned-threads.store')->middleware('admin');
Route::delete('pinned-threads/{thread}', 'PinnedThreadsController@destroy')->name('pinned-threads.destroy')->middleware('admin');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/profiles/{user:name}', 'ProfilesController@show')->name('profile');
Route::get('/profiles/{user:name}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user:name}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index');

Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user:name}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
Route::get('/api/channels', 'Api\ChannelsController@index');



Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
    'namespace' => 'Admin'
], function() {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
    Route::get('/channels', 'ChannelsController@index')->name('admin.channels.index');
    Route::post('/channels', 'ChannelsController@store')->name('admin.channels.store');
    Route::get('/channels/create', 'ChannelsController@create')->name('admin.channels.create');
    Route::get('/channels/{channel:slug}', 'ChannelsController@edit')->name('admin.channels.edit');
    Route::patch('/channels/{channel:slug}', 'ChannelsController@update')->name('admin.channels.update');
});