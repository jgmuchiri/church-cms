<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => TRUE]);

Route::group(['middleware' => 'web'], function () {

    Route::get('dashboard', ['uses' => function () {
        if(auth()->user()->role == 'admin')
            return view('admin.dashboard');
        return redirect('account');
    }]);

    Route::get('password/forgot', 'Auth\ForgotPasswordController@index')->name('password.forgot');

    Route::get('logout', 'Auth\LoginController@logout');

    Route::get('/', 'HomeController@index');

    Route::get('/home', 'HomeController@index');

    Route::get('register/confirm', 'Auth\AuthController@resendConfirmation');

    Route::get('register/verify/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'Auth\AuthController@confirmAccount',
    ]);

    Route::post('registerUser', 'UserController@registerUser');

    //public routes//
    Route::get('giving', 'HomeController@giving');

    //contact
    Route::get('contact', 'HomeController@contact');

    Route::post('contact', 'HomeController@sendMessage');

    //events
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', 'CalendarController@index');
        Route::post('/', 'CalendarController@store');
        Route::get('list', 'CalendarController@eventsList');
        Route::get('{id}/view', 'CalendarController@show');
        Route::get('{id}/register', 'CalendarController@registerEvent');
        Route::get('admin', 'CalendarController@calendarAdmin');
        Route::get('{id}/edit', 'CalendarController@edit');
        Route::post('{id}/edit', 'CalendarController@update');
        Route::get('/delete/{id}', 'CalendarController@destroy');
        Route::get('{id}/destroy', 'CalendarController@destroy');
        Route::get('church-schedule', 'CalendarController@churchSchedule');
        Route::post('church-schedule', 'CalendarController@churchScheduleStore');
        Route::patch('church-schedule/{id}', 'CalendarController@churchScheduleUpdate');
        Route::get('church-schedule/{id}/delete', 'CalendarController@churchScheduleDelete');
        Route::get('{id}', 'CalendarController@show');
    });

    //sermons
    Route::group(['prefix' => 'sermons'], function () {
        Route::get('/', 'SermonsController@index');
        Route::post('/', 'SermonsController@store')->name('create-sermon');
        Route::patch('/{id}', 'SermonsController@update')->name('update-sermon');

        Route::get('admin', 'SermonsController@sermonsAdmin');
        Route::get('admin/drafts', 'SermonsController@sermonsAdmin');
        Route::get('drafts', 'SermonsController@index');
        Route::get('create', 'SermonsController@create');

        Route::get('{id}/edit', 'SermonsController@edit');
        Route::get('{id}/delete', 'SermonsController@destroy');
        Route::get('{slug}', 'SermonsController@show');
    });

    //blog
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'BlogController@index');
        Route::get('admin', 'BlogController@admin');
        Route::get('/create', 'BlogController@create');
        Route::post('/create', 'BlogController@store');
        Route::get('{id}/edit', 'BlogController@edit');
        Route::post('{id}/update', 'BlogController@update');
        Route::get('{id}/delete', 'BlogController@destroy');
        Route::post('{id}/postComment', 'BlogController@postComment');
        Route::get('/comment/{id}/delete', 'BlogController@deleteComment');
        Route::get('categories', 'BlogController@categories');
        Route::post('categories', 'BlogController@storeCat');
        Route::patch('categories/{id}', 'BlogController@updateCat');
        Route::get('{slug}', 'BlogController@show');
    });

    //users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@users');
        Route::get('findUser', 'UserController@findUser');
        Route::get('{id}', 'UserController@index');
    });
    Route::group(['prefix' => 'birthdays'], function () {
        Route::get('/', 'BirthdayController@index');
        Route::get('{id}', 'BirthdayController@index');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('{id}', 'UserController@user');
        Route::post('{id}', 'UserController@updateUser');
    });

    //Roles
    Route::group(['prefix' => 'roles', 'middleware' => ['role:admin'], 'namespace' => 'Admin'], function () {
        Route::get('/', 'RolesController@index');
        Route::post('/', 'RolesController@store')->name('create.role');
        Route::put('{id}', 'RolesController@update');
    });

    //settings
    Route::group(['prefix' => 'settings', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'AdminController@settings');
        Route::post('/', 'AdminController@updateEnv');
        Route::post('backup', 'AdminController@backupEnv');
        Route::get('/', 'AdminController@settings');
        Route::post('/logo', 'AdminController@uploadLogo');
    });

    Route::get('debug-log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    //themes
    Route::group(['prefix' => 'theme', 'middleware' => 'auth'], function () {
        Route::get('/', 'ThemesController@index');
        Route::post('/', 'ThemesController@upload');
        Route::get('{id}/d', 'ThemesController@destroy');
        Route::get('{id}/select', 'ThemesController@selectTheme');
        Route::get('/browse', 'ThemesController@browse');
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', 'MenuController@mainMenu');
        Route::post('/', 'MenuController@storeMainMenu');
        Route::patch('/', 'MenuController@updateMainMenu');
        Route::post('/sort', 'MenuController@sortMenu');
        Route::get('/{id}/delete', 'MenuController@destroy');
    });

    Route::group(['prefix' => 'giving'], function () {
        Route::get('gift-options', 'GivingController@giftOptions')->name('gift-options');
        Route::post('gift-options', 'GivingController@storeGiftOption');
        Route::put('gift-options/{id}', 'GivingController@updateGiftOption');
        Route::get('gifts', 'GivingController@gifts');
        Route::post('gift', 'GivingController@showGift');
        Route::post('give', 'GivingController@give');
        Route::post('guest-giving', 'GivingController@manualGift');
        Route::get('history', 'GivingController@givingHistory');
        Route::get('recurring', 'GivingController@recurringGifts');
        Route::get('plan/{id}/{action}', 'GivingController@updateGiftPlan');

        Route::get('option-info/{id}', 'GivingController@getOptionInfo');
    });
    Route::post('guest-giving', 'GivingController@manualGift');

    //routes for all
    Route::get('account', 'UserController@userAccount');
    Route::get('profile', 'UserController@profile');
    Route::post('profile', 'UserController@updateProfile');
    Route::post('profile/password', 'UserController@updatePassword');

    //ministries
    Route::group(['prefix' => 'ministries'], function () {
        Route::get('/', 'MinistryController@index');
        Route::post('/', 'MinistryController@store');
        Route::patch('/', 'MinistryController@update')->name('update-ministry');

        Route::get('/{id}/edit', 'MinistryController@edit');

        //admin
        Route::get('/create', 'MinistryController@create');
        Route::get('{id}/edit', 'MinistryController@edit');
        Route::get('{id}/delete', 'MinistryController@destroy');

        Route::get('/admin', 'MinistryController@admin');
        Route::get('/categories', 'MinistryController@categories');

        Route::get('categories', 'MinistryController@categories');
        Route::post('categories', 'MinistryController@storeCat');
        Route::patch('categories/{id}', 'MinistryController@updateCat');

        Route::get('/{id}', 'MinistryController@show');
    });

    //messaging
    Route::group(['prefix' => 'messaging'], function () {
        Route::get('/admin', 'MessagingController@admin');
        Route::post('/send', 'MessagingController@send');
        Route::get('/history', 'MessagingController@history');
        Route::get('mail-groups', 'MessagingController@msgGroups');
        Route::get('mail-groups/{id}', 'MessagingController@msgGroups');
        Route::post('mail-groups', 'MessagingController@msgGroupsStore');
        Route::patch('mail-groups/{id}', 'MessagingController@msgGroupsUpdate');
        Route::get('mail-groups/{id}/delete', 'MessagingController@msgGroupsDestroy');
        Route::get('delete/{id}', 'MessagingController@destroy');
    });

    //templates
    Route::group(['prefix' => 'templates'], function () {
        Route::get('/', 'MessagingController@templates');
        Route::get('/create', 'MessagingController@createTemplate');
        Route::post('/', 'MessagingController@storeTemplate');
        Route::get('/{id}/edit', 'MessagingController@editTemplate');
        Route::post('/{id}/edit', 'MessagingController@updateTemplate');
        Route::get('/delete/{id}', 'MessagingController@destroyTemplate');

    });

    //support
    Route::group(['prefix' => 'support'], function () {
        Route::get('/', 'KbController@index');
        Route::get('topic/{id}', 'KbController@topic');
        Route::get('categories', 'KbController@categories');
        Route::post('categories', 'KbController@storeCategory');
        Route::patch('categories/{id}', 'KbController@updateCategory');
        Route::get('search', 'KbController@search');
        Route::post('sendQuestion', 'KbController@sendQuestion');

        Route::get('/create', 'KbController@create');
        Route::post('/create', 'KbController@store');
        Route::get('questions', 'KbController@questions');
        Route::get('question/{id}', 'KbController@question');
        Route::get('question/{id}/delete', 'KbController@destroy');
        Route::post('question/{id}', 'KbController@updateQuestion');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('downloadGiftsToDate', 'ReportsController@downloadGiftsToDate');
    });

    Route::group(['prefix' => 'kiosk'], function () {
        Route::get('/', 'KioskController@index');
    });
    Route::group(['prefix' => 'api'], function () {
        Route::get('events', 'CalendarController@eventsJSON');
    });
});

