<?php

/**
 * -----------------------------------------------------------------
 * NOTE : There is two routes has a name (user & group),
 * any change in these two route's name may cause an issue
 * if not modified in all places that used in (e.g Chatify class,
 * Controllers, chatify javascript file...).
 * -----------------------------------------------------------------
 */

use Illuminate\Support\Facades\Route;

// Define the controller namespace
$namespace = 'App\Http\Controllers\vendor\Chatify';

/*
* This is the main app route [Chatify Messenger]
*/
Route::get('/', $namespace . '\MessagesController@index')->name(config('chatify.routes.prefix'));

/**
 *  Fetch info for specific id [user/group]
 */
Route::post('/idInfo', $namespace . '\MessagesController@idFetchData');

/**
 * Send message route
 */
Route::post('/sendMessage', $namespace . '\MessagesController@send')->name('send.message');

/**
 * Fetch messages
 */
Route::post('/fetchMessages', $namespace . '\MessagesController@fetch')->name('fetch.messages');

/**
 * Download attachments route to create a downloadable links
 */
Route::get('/download/{fileName}', $namespace . '\MessagesController@download')->name(config('chatify.attachments.download_route_name'));

/**
 * Authentication for pusher private channels
 */
Route::post('/chat/auth', $namespace . '\MessagesController@pusherAuth')->name('pusher.auth');

/**
 * Make messages as seen
 */
Route::post('/makeSeen', $namespace . '\MessagesController@seen')->name('messages.seen');

/**
 * Get contacts
 */
Route::get('/getContacts', $namespace . '\MessagesController@getContacts')->name('contacts.get');

/**
 * Update contact item data
 */
Route::post('/updateContacts', $namespace . '\MessagesController@updateContactItem')->name('contacts.update');

/**
 * Star in favorite list
 */
Route::post('/star', $namespace . '\MessagesController@favorite')->name('star');

/**
 * get favorites list
 */
Route::post('/favorites', $namespace . '\MessagesController@getFavorites')->name('favorites');

/**
 * Search in messenger
 */
Route::get('/search', $namespace . '\MessagesController@search')->name('search');

/**
 * Get shared photos
 */
Route::post('/shared', $namespace . '\MessagesController@sharedPhotos')->name('shared');

/**
 * Delete Conversation
 */
Route::post('/deleteConversation', $namespace . '\MessagesController@deleteConversation')->name('conversation.delete');

/**
 * Delete Message
 */
Route::post('/deleteMessage', $namespace . '\MessagesController@deleteMessage')->name('message.delete');

/**
 * Update setting
 */
Route::post('/updateSettings', $namespace . '\MessagesController@updateSettings')->name('avatar.update');

/**
 * Set active status
 */
Route::post('/setActiveStatus', $namespace . '\MessagesController@setActiveStatus')->name('activeStatus.set');

/*
* [Group] view by id
*/
Route::get('/group/{id}', $namespace . '\MessagesController@index')->name('group');

/*
* user view by id.
* Note : If you added routes after the [User] which is the below one,
* it will considered as user id.
*
* e.g. - The commented routes below :
*/
// Route::get('/route', function(){ return 'Munaf'; }); // works as a route
Route::get('/{id}', $namespace . '\MessagesController@index')->name('user');
// Route::get('/route', function(){ return 'Munaf'; }); // works as a user id

Route::get('/getAllUsers', 'App\Http\Controllers\vendor\Chatify\MessagesController@getAllUsers')->name('users.all');