<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ChatifyCustomProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // تجاوز مسارات Chatify الافتراضية
        $this->overrideChatifyRoutes();
    }

    /**
     * Override Chatify routes with our custom routes
     */
    protected function overrideChatifyRoutes()
    {
        // تحميل المسارات المخصصة
        Route::group(['prefix' => config('chatify.routes.prefix'), 'middleware' => config('chatify.routes.middleware')], function () {
            Route::get('/', 'App\Http\Controllers\vendor\Chatify\MessagesController@index')->name(config('chatify.routes.prefix'));
            Route::post('/idInfo', 'App\Http\Controllers\vendor\Chatify\MessagesController@idFetchData');
            Route::post('/sendMessage', 'App\Http\Controllers\vendor\Chatify\MessagesController@send')->name('send.message');
            Route::post('/fetchMessages', 'App\Http\Controllers\vendor\Chatify\MessagesController@fetch')->name('fetch.messages');
            Route::get('/download/{fileName}', 'App\Http\Controllers\vendor\Chatify\MessagesController@download')->name(config('chatify.attachments.download_route_name'));
            Route::post('/chat/auth', 'App\Http\Controllers\vendor\Chatify\MessagesController@pusherAuth')->name('pusher.auth');
            Route::post('/makeSeen', 'App\Http\Controllers\vendor\Chatify\MessagesController@seen')->name('messages.seen');
            Route::get('/getContacts', 'App\Http\Controllers\vendor\Chatify\MessagesController@getContacts')->name('contacts.get');
            Route::post('/updateContacts', 'App\Http\Controllers\vendor\Chatify\MessagesController@updateContactItem')->name('contacts.update');
            Route::post('/star', 'App\Http\Controllers\vendor\Chatify\MessagesController@favorite')->name('star');
            Route::post('/favorites', 'App\Http\Controllers\vendor\Chatify\MessagesController@getFavorites')->name('favorites');
            Route::get('/search', 'App\Http\Controllers\vendor\Chatify\MessagesController@search')->name('search');
            Route::post('/shared', 'App\Http\Controllers\vendor\Chatify\MessagesController@sharedPhotos')->name('shared');
            Route::post('/deleteConversation', 'App\Http\Controllers\vendor\Chatify\MessagesController@deleteConversation')->name('conversation.delete');
            Route::post('/deleteMessage', 'App\Http\Controllers\vendor\Chatify\MessagesController@deleteMessage')->name('message.delete');
            Route::post('/updateSettings', 'App\Http\Controllers\vendor\Chatify\MessagesController@updateSettings')->name('avatar.update');
            Route::post('/setActiveStatus', 'App\Http\Controllers\vendor\Chatify\MessagesController@setActiveStatus')->name('activeStatus.set');
            Route::get('/group/{id}', 'App\Http\Controllers\vendor\Chatify\MessagesController@index')->name('group');
            Route::get('/{id}', 'App\Http\Controllers\vendor\Chatify\MessagesController@index')->name('user');
            Route::get('/getAllUsers', 'App\Http\Controllers\vendor\Chatify\MessagesController@getAllUsers')->name('users.all');
        });
    }
}