<?php
use App\User;
use Illuminate\Support\Facades\Auth;

Route::auth();
Route::group(['middleware' => 'web'], function () {
    if (Request()->segment(3) == "delete") {
        return view('errors.202');
    }

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.auth');
    });
    Route::post('login', 'Auth\AuthController@login');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@createUser');
    Route::get('register/confirm', 'Auth\AuthController@resendConfirmation');
    Route::get('register/verify/{confirmationCode}', [
        'as' => 'confirmation_path',
        'uses' => 'Auth\AuthController@confirmAccount'
    ]);

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLink');
    Route::post('password/reset', 'Auth\PasswordController@resetPassword');

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
        Route::get('admin', 'SermonsController@sermonsAdmin');
        Route::get('admin/drafts', 'SermonsController@sermonsAdmin');
        Route::get('drafts', 'SermonsController@index');
        Route::get('create', 'SermonsController@create');
        Route::post('create', 'SermonsController@store');
        Route::get('{id}/edit', 'SermonsController@edit');
        Route::post('{id}/edit', 'SermonsController@update');
        Route::get('{id}/delete', 'SermonsController@destroy');
        Route::get('{slug}', 'SermonsController@show');
    });

    //blog
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/', 'BlogController@index');
        Route::get('admin', ['middleware' => ['role:admin'], 'uses' => 'BlogController@admin']);
        Route::get('/create', ['middleware' => ['permission:blog-create'], 'uses' => 'BlogController@create']);
        Route::post('/create', ['middleware' => ['permission:blog-create'], 'uses' => 'BlogController@store']);
        Route::get('{id}/edit', ['middleware' => ['permission:blog-update'], 'uses' => 'BlogController@edit']);
        Route::post('{id}/update', ['middleware' => ['permission:blog-update'], 'uses' => 'BlogController@update']);
        Route::get('{id}/delete', ['middleware' => ['permission:blog-detete'], 'uses' => 'BlogController@destroy']);
        Route::post('{id}/postComment', 'BlogController@postComment');
        Route::get('/comment/{id}/delete', ['middleware' => ['ability:admin|owner,blog.comments-delete', 'true'], 'uses' => 'BlogController@deleteComment']);
        Route::get('categories', 'BlogController@categories');
        Route::post('categories', ['middleware' => ['role:admin'], 'uses' => 'BlogController@storeCat']);
        Route::patch('categories/{id}', ['middleware' => ['role:admin'], 'uses' => 'BlogController@updateCat']);
        Route::get('{slug}', 'BlogController@show');
    });

    //users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@users');
        Route::get('findUser', 'UserController@findUser');
        Route::get('{id}', 'UserController@index');
    });
    Route::group(['prefix'=>'birthdays'],function (){
        Route::get('/', 'UserController@birthdays');
        Route::get('{id}', 'UserController@birthdays');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('{id}', 'UserController@user');
        Route::post('{id}', 'UserController@updateUser');
        Route::post('{id}/roles', 'UserController@updateUserRoles');
    });
    Route::post('registerUser', 'UserController@registerUser');

    //admin routes

    Route::get('dashboard', 'AdminController@index');
    //ADMIN

    //roles
    Route::group(['prefix' => 'roles', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'Auth\AuthController@roles');
        Route::post('/', 'Auth\AuthController@newRole');
        Route::get('/getRoles', 'Auth\AuthController@rolesJson');
    });

    //permissions
    Route::group(['prefix' => 'permissions', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'Auth\AuthController@permissions');
        Route::post('/', 'Auth\AuthController@storePermission');
        Route::patch('/', 'Auth\AuthController@updatePermission');
        Route::get('delete/{id}', 'Auth\AuthController@deletePermission');
        Route::get('search/{key}', 'Auth\AuthController@permissions');
        Route::get('search', 'Auth\AuthController@permissions');
        Route::post('search/{key}', 'Auth\AuthController@permissions');
        Route::post('search', 'Auth\AuthController@permissions');
    });

    //settings
    Route::group(['prefix' => 'settings', 'middleware' => ['role:admin']], function () {
        Route::get('/', 'AdminController@settings');
        Route::post('/', 'AdminController@updateEnv');
        Route::post('backup', 'AdminController@backupEnv');
        Route::get('/', 'AdminController@settings');
        Route::post('/logo', 'AdminController@uploadLogo');

        Route::group(['prefix' => 'menu'], function () {
            Route::get('/', 'AdminController@mainMenu');
            Route::post('/', 'AdminController@storeMainMenu');
            Route::patch('/', 'AdminController@updateMainMenu');
            Route::post('/sort','AdminController@sortMenu');
        });

        Route::group(['prefix' => 'themes','middleware'=>'auth'], function () {
            Route::get('/', 'ThemesController@index');
            Route::post('/', 'ThemesController@upload');
            Route::get('{id}/delete', 'ThemesController@deleteTheme');
            Route::get('{id}/select', 'ThemesController@selectTheme');
        });
    });


    Route::group(['prefix' => 'giving','middleware'=>'auth'], function () {
        Route::get('gift-options', 'TransactionsController@giftOptions');
        Route::post('gift-options', 'TransactionsController@storeGiftOption');
        Route::put('gift-options/{id}', 'TransactionsController@updateGiftOption');
        Route::get('gifts', 'TransactionsController@gifts');
        Route::get('gift/{id}', 'TransactionsController@showGift');
        Route::post('manual-giving', 'TransactionsController@manualGift');
        Route::post('guest-giving', 'TransactionsController@manualGift');

        Route::get('/history', 'TransactionsController@givingHistory');
        Route::get('recurring', 'TransactionsController@recurringGifts');
        Route::get('plan/{id}/{action}', 'TransactionsController@updateGiftPlan');
    });


    //routes for all
    Route::get('account', 'UserController@userAccount');
    Route::get('profile', 'UserController@profile');
    Route::post('profile', 'UserController@updateProfile');

    //ministries
    Route::group(['prefix' => 'ministries'], function () {
        Route::get('/', 'MinistryController@index');
        Route::get('/{id}/edit', 'MinistryController@edit');

        //admin
        Route::get('/create', 'MinistryController@create');
        Route::post('/create', 'MinistryController@store');
        Route::get('{id}/edit', 'MinistryController@edit');
        Route::post('update', 'MinistryController@update');
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


    Route::group(['prefix' => 'themes'], function () {
        Route::get('/browse', 'ThemesController@browse');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('downloadGiftsToDate', 'ReportsController@downloadGiftsToDate');
    });

    Route::group(['prefix' => 'kiosk'], function () {
        Route::get('/', 'KioskController@index');
    });
    Route::group(['prefix' => 'api'], function () {
       Route::get('events','CalendarController@eventsJSON');
    });
});

