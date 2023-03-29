<?php

use Illuminate\Http\Response;
// Auth::routes();

// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.reset');
// Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');

Route::get('test_mail_view', [
    'uses' => "Admin\SubscriptionsController@test_mail_view",
    'as' => 'addsubscripti',
    'title' => __('pages.add-new-subscription'),
]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('mark_notifications_as_read', 'HomeController@markNotificationsAsRead')->name('markNotificationsAsRead');
Route::post('upload', 'HomeController@upload')->name('upload');

Route::post('/forgot-your-password', 'Site\ForgotPasswordController@postForgotPassword');
Route::get('/forgot-your-password', [
    'uses' => 'Site\ForgotPasswordController@forgotPassword',
    'as' => 'forgotPassword'
]);

Route::get('/password/reset/{token}', 'Site\ForgotPasswordController@passwordResBlade');
Route::post('/change_password', 'Site\ForgotPasswordController@changePassword');


Route::group(['prefix' => 'site'], function () {
    Route::get('switch_language/{locale}', function ($locale) {
        if (!in_array($locale, ['en', 'ar'])) {
            abort(400);
        }

        Session::put('lang', $locale);

        $referrer = Request::server('HTTP_REFERER');
        if (!$referrer || ($referrer && is_numeric(substr($referrer, -1)))) {
            return redirect(url('site'));
        }

        return redirect()->back();
    });

    Route::get('/email', 'EmailController@create');
    Route::post('/email', 'EmailController@receiveEmail')->name('send.email');

    Route::get('/', 'Site\HomeController@index')->name('site-home');

    Route::get('blog/{id}', 'Site\BlogController@show')->name('site-blog-view');
    Route::get('blog', 'Site\BlogController@index')->name('site-blog-index');

    Route::get('course/{id}', 'Site\CourseController@show')->name('site-courses-view');
    Route::post('course/store_review', 'Site\CourseController@storeReview')->name('site-courses-storeReview');
    Route::get('courses/category/{catId}', 'Site\CourseController@indexCat')->name('site-courses-index_category');
    Route::get('courses', 'Site\CourseController@index')->name('site-courses-index');

    Route::get('service/{id}', 'Site\ServiceController@show')->name('site-services-view');
    Route::get('services', 'Site\ServiceController@index')->name('site-services-index');

    Route::get('contact', 'Site\HomeController@contact')->name('site-contact');
    Route::post('contact', 'Site\HomeController@storeContact')->name('site-courses-storeContact');

    Route::get('consult', 'Site\HomeController@consult')->name('site-consult');
    Route::post('consult', 'Site\HomeController@storeConsult')->name('site-courses-storeConsult');

    Route::get('about', 'Site\HomeController@about')->name('site-about');
    Route::get('know', 'Site\HomeController@know')->name('site-know');
    Route::get('discover', 'Site\HomeController@discover')->name('site-discover');
    Route::get('faq', 'Site\HomeController@faq')->name('site-faq');
    Route::get('page/{key}', 'Site\HomeController@showPage')->name('site-pages-view');

    Route::post('newsletter', 'Site\HomeController@storeNewsletter')->name('site-storeNewsletter');
});

Route::get('login', 'Site\UserController@getLogin')->name('login')->middleware('guest');
Route::get('forgotPassword', 'Site\UserController@showLinkRequestForm')->name('forgotPassword')->middleware('guest');
Route::post('do-login', 'Site\UserController@doLogin')->name('do-login');
Route::get('logout', 'Site\UserController@logout')->name('logout');
Route::get('register', 'Site\UserController@getRegister')->name('register')->middleware('guest');
Route::post('do-register', 'Site\UserController@doRegister')->name('do-register');

/*Route::get('login', 'Admin\Auth\LoginController@getLogin')->name('login')->middleware('guest');
Route::post('do-login','Admin\Auth\LoginController@doLogin')->name('do-login');
Route::get('logout', 'Admin\Auth\LoginController@logout')->name('logout');
Route::get('register', 'Admin\Auth\LoginController@getRegister')->name('register')->middleware('guest');
Route::post('do-register','Admin\Auth\LoginController@doRegister')->name('do-register');*/

//Route::group(['prefix' => 'admin','middleware' => ['auth','checkRole']], function () {

// files group
Route::group(['prefix' => 'files', 'middleware' => ['auth', 'checkRole']], function () {

    # files postupdate
    Route::post('postupdate/{id}/{group}', [
        'uses' => 'Admin\FilesController@update',
        'as' => 'postupdatefiles',
        'title' => __('pages.edit-files'),
        'child' => [
            'destroyfile'
        ]
    ]);


    # files delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\FilesController@destroy',
        'as' => 'destroyfile',
        'title' => __('pages.delete-files'),
    ]);
});

// users group
Route::group(['prefix' => 'users', 'middleware' => ['auth', 'checkRole']], function () {

    # users index
    Route::get('/', [
        'uses' => 'Admin\UsersController@index',
        'as' => 'users',
        'title' => __('pages.user-list'),
        'child' => [
            'addusers',
            'postadduser',
            'getupdateuser',
            'postupdateuser',
            'destroyuser',
            'DatatableCourses',
            'DatatableGroups',
            'DatatableUsersFiles',
            'destroyCourseFromList',
            'destroyGroupFromList',
            'postadduserfiles',
            'postupdatefilesUsers',
        ]
    ]);

    # users add
    Route::get('create', [
        'uses' => "Admin\UsersController@create",
        'as' => 'addusers',
        'title' => __('pages.add-user'),
    ]);

    # users postadd
    Route::post('post-user', [
        'uses' => 'Admin\UsersController@store',
        'as' => 'postadduser',
        'title' => __('pages.store-user'),
    ]);

    # users update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\UsersController@edit',
        'as' => 'getupdateuser',
        'title' => __('pages.edit-user'),
    ]);

    # users postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\UsersController@update',
        'as' => 'postupdateuser',
        'title' => __('pages.update-user'),
    ]);

    # users delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\UsersController@destroy',
        'as' => 'destroyuser',
        'title' => __('pages.delete-user'),
    ]);


    # users courses datatable
    Route::get('/datatable-course/{id}', [
        'uses' => 'Admin\UsersController@DatatableCourses',
        'as' => 'DatatableCourses',
        'title' => __('pages.user-courses'),
    ]);

    # users groups datatable
    Route::get('/datatable-groups/{id}', [
        'uses' => 'Admin\UsersController@DatatableUsersGroups',
        'as' => 'DatatableGroups',
        'title' => __('pages.user-groups'),
    ]);


    # users files datatable
    Route::get('/datatable-files/{id}', [
        'uses' => 'Admin\UsersController@DatatableUsersFiles',
        'as' => 'DatatableUsersFiles',
        'title' => __('pages.user-files'),
    ]);


    Route::get('/destroy-courseFrom-List/{user_id}/{course_id}', [
        'uses' => 'Admin\UsersController@destroyCourseFromList',
        'as' => 'destroyCourseFromList',
        'title' => __('pages.delete-course-from-user'),
    ]);

    Route::get('/destroy-groupFrom-List/{user_id}/{group_id}', [
        'uses' => 'Admin\UsersController@destroyGroupFromList',
        'as' => 'destroyGroupFromList',
        'title' => __('pages.delete-group-user'),
    ]);


    # users postadd
    Route::post('post-file/{user_id}/', [
        'uses' => 'Admin\UsersController@UploadFile',
        'as' => 'postadduserfiles',
        'title' => __('pages.delete-file-from-user'),
    ]);


    # files postupdate
    Route::post('postupdate/{id}/{user}', [
        'uses' => 'Admin\UsersController@updateFile',
        'as' => 'postupdatefilesUsers',
        'title' => __('pages.update-file-user'),
    ]);
});

// courses group
Route::group(['prefix' => 'courses', 'middleware' => ['auth', 'checkRole']], function () {

    # courses index
    Route::get('/', [
        'uses' => 'Admin\CoursesController@index',
        'as' => 'courses',
        'title' => __('pages.courses'),
        'child' => [
            'addcourses',
            'showAll',
            'postaddcourses',
            'getupdatecourses',
            'postupdatecourses',
            'destroycourses',
            'DatatableUsersCourses',
            'DatatableCoursesGroups',
            'destroyUserFromList',
            'addUserFromList',
            'destroyGroupFromList',
            'addGroupFromList',

        ]
    ]);

    # courses add
    Route::get('create', [
        'uses' => "Admin\CoursesController@create",
        'as' => 'addcourses',
        'title' => __('pages.create-course'),
    ]);

    Route::get('show-all/{id}', [
        'uses' => "Admin\CoursesController@show",
        'as' => 'showAll',
        'title' => __('pages.show-all-course'),
    ]);

    # courses postadd
    Route::post('post-course', [
        'uses' => 'Admin\CoursesController@store',
        'as' => 'postaddcourses',
        'title' => __('pages.store-course'),
    ]);

    # courses update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\CoursesController@edit',
        'as' => 'getupdatecourses',
        'title' => __('pages.edit-course'),
    ]);

    # courses postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\CoursesController@update',
        'as' => 'postupdatecourses',
        'title' => __('pages.update-course'),
    ]);

    # courses delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\CoursesController@destroy',
        'as' => 'destroycourses',
        'title' => __('pages.delete-course'),
    ]);

    # users groups datatable
    Route::get('/datatable-users/{id}', [
        'uses' => 'Admin\CoursesController@DatatableUsersCourses',
        'as' => 'DatatableUsersCourses',
        'title' => __('pages.show-user-course'),
    ]);

    //    # courses user datatable
    //    Route::get('/datatable-user/{id}', [
    //        'uses' => 'Admin\CoursesController@datatableUsers',
    //        'as' => 'datatableUsers',
    //        'title' => ' ',
    //    ]);

    # users groups datatable
    Route::get('/datatable-groups/{id}', [
        'uses' => 'Admin\CoursesController@DatatableCoursesGroups',
        'as' => 'DatatableCoursesGroups',
        'title' => __('pages.show-group-relate-course'),
    ]);


    Route::get('/destroy-courseFrom-List/{user_id}/{course_id}', [
        'uses' => 'Admin\CoursesController@destroyUserFromList',
        'as' => 'destroyUserFromList',
        'title' => __('pages.delete-user-from-course'),
    ]);


    Route::get('/add-courseFrom-List/{user_id}/{course_id}', [
        'uses' => 'Admin\CoursesController@addUserFromList',
        'as' => 'addUserFromList',
        'title' => __('pages.add-user-to-course'),
    ]);


    Route::get('/destroy-groupFrom-List/{group_id}/{course_id}', [
        'uses' => 'Admin\CoursesController@destroyGroupFromList',
        'as' => 'destroyGroupFromList',
        'title' => __('pages.delete-group-from-course'),
    ]);


    Route::get('/add-groupFrom-List/{group_id}/{course_id}', [
        'uses' => 'Admin\CoursesController@addGroupFromList',
        'as' => 'addGroupFromList',
        'title' => __('pages.add-group-to-course'),
    ]);
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/datatable-users-news-letters', [
        'uses' => 'HomeController@DataTableUsersNewsLetters',
        'as' => 'DataTableUsersNewsLetters',
        'title' => 'عرض المشتركين في النشرة البريدية',
    ]);

    Route::get('/delete-newsletters-subscription/{id}', [
        'uses' => 'HomeController@destroyNewslettersUser',
        'as' => 'DeleteNewslettersSubscription',
        'title' => 'حذف مشترك من النشرة البريدية',
    ]);
});

Route::group(['prefix' => 'lessons', 'middleware' => ['auth', 'checkRole']], function () {

    # groups index
    Route::get('/', [
        'uses' => 'Admin\CoursesLessonsController@index',
        'as' => 'Lessons',
        'title' => __('pages.lessons'),
        'child' => [
            'addlessons',
            'showLesson',
            'postaddlessons',
            'getupdatelessons',
            'postupdatelessons',
            'destroylessons',
            'DatatableUsersCoursesLesson',
            'postaddlessonsTrams'
        ]
    ]);


    Route::get('/datatable-users-lesson/{id}', [
        'uses' => 'Admin\CoursesLessonsController@DatatableUsersCourses',
        'as' => 'DatatableUsersCoursesLesson',
        'title' => __('pages.show-lesson-course'),
    ]);


    # lessons add
    Route::get('create/{id}', [
        'uses' => "Admin\CoursesLessonsController@create",
        'as' => 'addlessons',
        'title' => __('pages.add-lessons'),
    ]);

    # lessons show
    Route::get('show/{id}', [
        'uses' => "Admin\CoursesLessonsController@show",
        'as' => 'showLesson',
        'title' => __('pages.show-lesson-course'),
    ]);

    # lessons postadd
    Route::post('post-lesson', [
        'uses' => 'Admin\CoursesLessonsController@store',
        'as' => 'postaddlessons',
        'title' => __('pages.store-lessons'),
    ]);


    # lessons postadd
    Route::post('post-lesson-terms/{id}', [
        'uses' => 'Admin\CoursesLessonsController@trams',
        'as' => 'postaddlessonsTrams',
        'title' => __('pages.store-lessons-terms'),
    ]);


    # lessons edit
    Route::get('/edit/{course_id}/{lesson_id}', [
        'uses' => 'Admin\CoursesLessonsController@edit',
        'as' => 'getupdatelessons',
        'title' => __('pages.edit-lessons'),
    ]);

    # lessons postupdate
    Route::post('postupdate/{course_id}/{lesson_id}', [
        'uses' => 'Admin\CoursesLessonsController@update',
        'as' => 'postupdatelessons',
        'title' => __('pages.update-lessons'),
    ]);
});

Route::group(['prefix' => 'surveys/{courseId}', 'middleware' => ['auth', 'checkRole']], function () {
    # surveys
    Route::get('/', [
        'uses' => 'Admin\SurveyController@index',
        'as' => 'Surveys',
        'title' => __('pages.surveys'),
        'child' => [
            'addsurveys',
            'postaddsurveys',
            'editsurveys',
            'updatesurveys',
            'SurveysResults'
        ]
    ]);

    # surveys add
    Route::get('/create', [
        'uses' => "Admin\SurveyController@create",
        'as' => 'addsurveys',
        'title' => __('pages.create-survey'),
    ]);

    # surveys postadd
    Route::post('/post-survey', [
        'uses' => 'Admin\SurveyController@store',
        'as' => 'postaddsurveys',
        'title' => __('pages.store-survey'),
    ]);

    # surveys edit
    Route::get('/edit/{id}', [
        'uses' => "Admin\SurveyController@edit",
        'as' => 'editsurveys',
        'title' => __('pages.edit-survey'),
    ]);

    # surveys update
    Route::post('/update-survey/{id}', [
        'uses' => 'Admin\SurveyController@update',
        'as' => 'updatesurveys',
        'title' => __('pages.update-survey'),
    ]);

    # surveys results
    Route::get('/results/{id}', [
        'uses' => 'Admin\SurveyController@results',
        'as' => 'SurveysResults',
        'title' => __('pages.surveys-results'),
    ]);
});

// groups group
Route::group(['prefix' => 'groups', 'middleware' => ['auth', 'checkRole']], function () {

    # groups index
    Route::get('/', [
        'uses' => 'Admin\GroupsController@index',
        'as' => 'groups',
        'title' => __('pages.groups'),
        'child' => [
            'addgroups',
            'postaddgroups',
            'getupdategroups',
            'postupdategroups',
            'destroygroups',
            'DatatableUsersGroups',
            'destroyGroupFromList',
            'addGroupFromList',
            'DatatableCoursesGroups',
            'destroyCourseFromList',
            'addCourseFromList',
            'postaddgroupsfile',
            'DatatableUsersFiles'
        ]
    ]);

    # groups add
    Route::get('create', [
        'uses' => "Admin\GroupsController@create",
        'as' => 'addgroups',
        'title' => __('pages.add-group'),
    ]);

    # groups postadd
    Route::post('post-group', [
        'uses' => 'Admin\GroupsController@store',
        'as' => 'postaddgroups',
        'title' => __('pages.store-group'),
    ]);

    # groups update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\GroupsController@edit',
        'as' => 'getupdategroups',
        'title' => __('pages.edit-group'),
    ]);

    # groups postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\GroupsController@update',
        'as' => 'postupdategroups',
        'title' => __('pages.update-group'),
    ]);

    # groups delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\GroupsController@destroy',
        'as' => 'destroygroups',
        'title' => __('pages.delete-group'),
    ]);


    # users groups datatable
    Route::get('/datatable-users/{id}', [
        'uses' => 'Admin\GroupsController@DatatableUsersGroups',
        'as' => 'DatatableUsersGroups',
        'title' => __('pages.show-user-relate-group'),
    ]);


    Route::get('/destroy-groupFrom-List/{group_id}/{student_id}', [
        'uses' => 'Admin\GroupsController@destroyGroupFromList',
        'as' => 'destroyGroupFromList',
        'title' => __('pages.delete-user-from-group'),
    ]);


    Route::get('/add-groupFrom-List/{group_id}/{student_id}', [
        'uses' => 'Admin\GroupsController@addGroupFromList',
        'as' => 'addGroupFromList',
        'title' => __('pages.add-user-to-group'),
    ]);


    //courses groups datatable
    Route::get('/datatable-courses/{id}', [
        'uses' => 'Admin\GroupsController@DatatableCoursesGroups',
        'as' => 'DatatableCoursesGroups',
        'title' => __('pages.show-course-relate-group'),
    ]);


    Route::get('/destroy-courseFrom-List/{group_id}/{course_id}', [
        'uses' => 'Admin\GroupsController@destroyCourseFromList',
        'as' => 'destroyCourseFromList',
        'title' => __('pages.delete-course-from-group'),
    ]);


    Route::get('/add-courseFrom-List/{group_id}/{course_id}', [
        'uses' => 'Admin\GroupsController@addCourseFromList',
        'as' => 'addCourseFromList',
        'title' => __('pages.add-course-to-group'),
    ]);


    # users postadd
    Route::post('post-file-upload/{group_id}', [
        'uses' => 'Admin\GroupsController@uploadFile',
        'as' => 'postaddgroupsfile',
        'title' => __('pages.add-file-form-group'),
    ]);


    # groups files datatable
    Route::get('/datatable-files/{id}', [
        'uses' => 'Admin\GroupsController@DatatableUsersFiles',
        'as' => 'DatatableUsersFiles',
        'title' => __('pages.show-file-form-group'),
    ]);
});

Route::group(['prefix' => 'categories', 'middleware' => ['auth', 'checkRole']], function () {

    # groups index
    Route::get('/', [
        'uses' => 'Admin\CategoriesCoursesController@index',
        'as' => 'categories',
        'title' => __('pages.catogries'),
        'child' => [
            'addcategories',
            'postaddcategories',
            'getupdatecategories',
            'postupdatecategories',
            'destroycategories',
        ]
    ]);

    # groups add
    Route::get('create', [
        'uses' => "Admin\CategoriesCoursesController@create",
        'as' => 'addcategories',
        'title' => __('pages.add-category'),
    ]);

    # groups postadd
    Route::post('post-categorie', [
        'uses' => 'Admin\CategoriesCoursesController@store',
        'as' => 'postaddcategories',
        'title' => __('pages.store-category'),
    ]);

    # groups update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\CategoriesCoursesController@edit',
        'as' => 'getupdatecategories',
        'title' => __('pages.edit-category'),
    ]);

    # groups postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\CategoriesCoursesController@update',
        'as' => 'postupdatecategories',
        'title' => __('pages.update-category'),
    ]);

    # groups delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\CategoriesCoursesController@destroy',
        'as' => 'destroycategories',
        'title' => __('pages.delete-category'),
    ]);
});

// events group
Route::post('events/store_for_student', 'Admin\EventsController@storeForStudent');

/*Route::group(['prefix' => 'events', 'middleware' => ['auth', 'checkRole']], function () {

        # events index
        Route::get('/', [
            'uses' => 'Admin\EventsController@index',
            'as' => 'events',
            'title' => __('pages.events'),
            'child' => [
                'addevents',
                'postaddevents',
                'getupdateevents',
                'postupdateevents',
                'destroyevents'
            ]
        ]);

        # events add
        Route::get('create', [
            'uses' => "Admin\EventsController@create",
            'as' => 'addevents',
            'title' => __('pages.add-event'),
        ]);

        # events postadd
        Route::post('post-events', [
            'uses' => 'Admin\EventsController@store',
            'as' => 'postaddevents',
            'title' => __('pages.store-event'),
        ]);

        # events update
        Route::get('/edit/{id}', [
            'uses' => 'Admin\EventsController@edit',
            'as' => 'getupdateevents',
            'title' => __('pages.edit-event'),
        ]);

        # events postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Admin\EventsController@update',
            'as' => 'postupdateevents',
            'title' => __('pages.update-event'),
        ]);

        # events delete
        Route::get('/delete/{id}', [
            'uses' => 'Admin\EventsController@destroy',
            'as' => 'destroyevents',
            'title' => __('pages.delete-event'),
        ]);


    });

// notification group
    Route::group(['prefix' => 'notification', 'middleware' => ['auth', 'checkRole']], function () {

        # notification index
        Route::get('/', [
            'uses' => 'Admin\NotificationsController@index',
            'as' => 'notifications',
            'title' => __('pages.notifications'),
            'child' => [
                'addnotifications',
                'postaddnotifications',
                'getupdatenotifications',
                'postupdatenotifications',
                'destroynotifications',
                'DatatableLogs',
                'destroyLogs'
            ]
        ]);

        # notification add
        Route::get('create', [
            'uses' => "Admin\NotificationsController@create",
            'as' => 'addnotifications',
            'title' => __('pages.add-notification'),
        ]);

        # notification postadd
        Route::post('post-notification', [
            'uses' => 'Admin\NotificationsController@store',
            'as' => 'postaddnotifications',
            'title' => __('pages.store-notification'),
        ]);

        # notification update
        Route::get('/edit/{id}', [
            'uses' => 'Admin\NotificationsController@edit',
            'as' => 'getupdatenotifications',
            'title' => __('pages.edit-notification'),
        ]);

        # notification postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Admin\NotificationsController@update',
            'as' => 'postupdatenotifications',
            'title' => __('pages.update-notification'),
        ]);

        # notification delete
        Route::get('/delete/{id}', [
            'uses' => 'Admin\NotificationsController@destroy',
            'as' => 'destroynotifications',
            'title' => __('pages.delete-notification'),
        ]);


        //notification  datatable
        Route::get('/datatable-notification/logs', [
            'uses' => 'Admin\NotificationsController@DatatableLogs',
            'as' => 'DatatableLogs',
            'title' => __('pages.show-all-message-sent'),
        ]);


        # notification delete
        Route::get('/delete-logs/{id}', [
            'uses' => 'Admin\NotificationsController@destroyLogs',
            'as' => 'destroyLogs',
            'title' => __('pages.delete-message-sent'),
        ]);

    });*/

// setting group
Route::group(['prefix' => 'setting', 'middleware' => ['auth', 'checkRole']], function () {
    # setting page
    Route::get('/', [
        'uses' => 'Admin\SettingController@index',
        'as' => 'setting',
        'title' => __('pages.setting'),
        'child' => [
            'updatefirsttap',
            'updatesecondtap',
            'updatethirdtap'

        ]
    ]);

    # update first tap
    Route::post('update-first-tap', [
        'uses' => 'Admin\SettingController@UpdateFristTap',
        'as' => 'updatefirsttap',
        'title' => __('pages.update-first-setting'),
    ]);

    # update second tap
    Route::post('update-second-tap', [
        'uses' => 'Admin\SettingController@UpdateSecondTap',
        'as' => 'updatesecondtap',
        'title' => __('pages.update-second-setting'),
    ]);

    # update third tap
    Route::post('update-third-tap', [
        'uses' => 'Admin\SettingController@UpdateThirdTap',
        'as' => 'updatethirdtap',
        'title' => __('pages.update-games'),
    ]);
});

// permissions group
Route::group(['prefix' => 'permissions', 'middleware' => ['auth', 'checkRole']], function () {
    # add permissions page
    Route::get('/', [
        'uses' => 'Admin\PermissionsController@PermissionsPage',
        'as' => 'permissions',
        'title' => __('pages.permissions'),
        'child' => [
            'storepermissions',
            'editpermissionpage',
            'updatepermission',
            'deletepermission'
        ]
    ]);

    # store permissions
    Route::post('store-permission', [
        'uses' => 'Admin\PermissionsController@AddPermissions',
        'as' => 'storepermissions',
        'title' => __('pages.store-permission'),
    ]);

    # edit permission
    Route::get('edit-permission/{id}', [
        'uses' => 'Admin\PermissionsController@EditPermissions',
        'as' => 'editpermissionpage',
        'title' => __('pages.edit-permission'),
    ]);

    #update permission
    Route::post('update-permission', [
        'uses' => 'Admin\PermissionsController@UpdatePermission',
        'as' => 'updatepermission',
        'title' => __('pages.update-permission')
    ]);


    # permission delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\PermissionsController@DeletePermission',
        'as' => 'deletepermission',
        'title' => __('pages.delete-permission'),
    ]);
});

//});

// services group
Route::group(['prefix' => 'services', 'middleware' => ['auth', 'checkRole']], function () {

    # services index
    Route::get('/', [
        'uses' => 'Admin\ServiceController@index',
        'as' => 'services',
        'title' => __('pages.services'),
        'child' => [
            'addservices',
            'postaddservices',
            'getupdateservices',
            'postupdateservices',
            'destroyservices'
        ]
    ]);

    # services add
    Route::get('create', [
        'uses' => "Admin\ServiceController@create",
        'as' => 'addservices',
        'title' => __('pages.add-new-service'),
    ]);

    # services postadd
    Route::post('post-service', [
        'uses' => 'Admin\ServiceController@store',
        'as' => 'postaddservices',
        'title' => __('pages.store-service'),
    ]);

    # services update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\ServiceController@edit',
        'as' => 'getupdateservices',
        'title' => __('pages.edit-service'),
    ]);

    # services postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\ServiceController@update',
        'as' => 'postupdateservices',
        'title' => __('pages.update-service'),
    ]);

    # services delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\ServiceController@destroy',
        'as' => 'destroyservices',
        'title' => __('pages.delete-service'),
    ]);
});

// blog group
Route::group(['prefix' => 'blog', 'middleware' => ['auth', 'checkRole']], function () {

    # blog index
    Route::get('/', [
        'uses' => 'Admin\BlogController@index',
        'as' => 'blog',
        'title' => __('pages.blog'),
        'child' => [
            'addblog',
            'postaddblog',
            'getupdateblog',
            'postupdateblog',
            'destroyblog'
        ]
    ]);

    # blog add
    Route::get('create', [
        'uses' => "Admin\BlogController@create",
        'as' => 'addblog',
        'title' => __('pages.add-new-blog'),
    ]);

    # blog postadd
    Route::post('post-blog', [
        'uses' => 'Admin\BlogController@store',
        'as' => 'postaddblog',
        'title' => __('pages.store-blog'),
    ]);

    # blog update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\BlogController@edit',
        'as' => 'getupdateblog',
        'title' => __('pages.edit-blog'),
    ]);

    # blog postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\BlogController@update',
        'as' => 'postupdateblog',
        'title' => __('pages.update-blog'),
    ]);

    # blog delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\BlogController@destroy',
        'as' => 'destroyblog',
        'title' => __('pages.delete-blog'),
    ]);
});

// faqs group
Route::group(['prefix' => 'faqs', 'middleware' => ['auth', 'checkRole']], function () {

    # faq index
    Route::get('/', [
        'uses' => 'Admin\FaqsController@index',
        'as' => 'faqs',
        'title' => __('pages.faqs'),
        'child' => [
            'addfaq',
            'postaddfaq',
            'getupdatefaq',
            'postupdatefaq',
            'destroyfaq'
        ]
    ]);

    # faq add
    Route::get('create', [
        'uses' => "Admin\FaqsController@create",
        'as' => 'addfaq',
        'title' => __('pages.add-new-faq'),
    ]);

    # faq postadd
    Route::post('post-faq', [
        'uses' => 'Admin\FaqsController@store',
        'as' => 'postaddfaq',
        'title' => __('pages.store-faq'),
    ]);

    # faq update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\FaqsController@edit',
        'as' => 'getupdatefaq',
        'title' => __('pages.edit-faq'),
    ]);

    # faq postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\FaqsController@update',
        'as' => 'postupdatefaq',
        'title' => __('pages.update-faq'),
    ]);

    # faq delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\FaqsController@destroy',
        'as' => 'destroy_faq',
        'title' => __('pages.delete-faq'),
    ]);
});







// e_wallets group
Route::group(['prefix' => 'e_wallets', 'middleware' => ['auth', 'checkRole']], function () {

    # blog index
    Route::get('/', [
        'uses' => 'Admin\E_WalletsController@index',
        'as' => 'e_wallets',
        'title' => __('pages.e_wallets'),
        'child' => [
            'addblog',
            'postaddblog',
            'getupdateblog',
            'postupdateblog',
            'destroyblog'
        ]
    ]);

    # blog add
    Route::get('create', [
        'uses' => "Admin\E_WalletsController@create",
        'as' => 'adde_wallet',
        'title' => __('pages.add-new-e_wallet'),
    ]);

    # blog postadd
    Route::post('post-e_wallet', [
        'uses' => 'Admin\E_WalletsController@store',
        'as' => 'postadde_wallet',
        'title' => __('pages.store-e_wallet'),
    ]);

    # blog update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\E_WalletsController@edit',
        'as' => 'getupdatee_wallet',
        'title' => __('pages.edit-e_wallet'),
    ]);

    # blog postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\E_WalletsController@update',
        'as' => 'postupdatee_wallet',
        'title' => __('pages.update-e_wallet'),
    ]);

    # blog delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\E_WalletsController@destroy',
        'as' => 'destroye_wallet',
        'title' => __('pages.delete-e_wallet'),
    ]);
});

// banks group
Route::group(['prefix' => 'banks', 'middleware' => ['auth', 'checkRole']], function () {

    # banks index
    Route::get('/', [
        'uses' => 'Admin\BanksController@index',
        'as' => 'banks',
        'title' => __('pages.banks'),
        'child' => [
            'addbank',
            'postaddbank',
            'getupdatebank',
            'postupdatebank',
            'destroybank'
        ]
    ]);

    # blog add
    Route::get('create', [
        'uses' => "Admin\BanksController@create",
        'as' => 'addbank',
        'title' => __('pages.add-new-bank'),
    ]);

    # blog postadd
    Route::post('post-bank', [
        'uses' => 'Admin\BanksController@store',
        'as' => 'postaddbank',
        'title' => __('pages.store-bank'),
    ]);

    # blog update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\BanksController@edit',
        'as' => 'getupdatebank',
        'title' => __('pages.edit-bank'),
    ]);

    # blog postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\BanksController@update',
        'as' => 'postupdatebank',
        'title' => __('pages.update-bank'),
    ]);

    # blog delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\BanksController@destroy',
        'as' => 'destroybank',
        'title' => __('pages.delete-bank'),
    ]);
});


// subscriptions group
Route::group(['prefix' => 'subscriptions', 'middleware' => ['auth', 'checkRole']], function () {

    # banks index
    Route::get('/', [
        'uses' => 'Admin\SubscriptionsController@index',
        'as' => 'subscriptions',
        'title' => __('pages.subscriptions'),
        'child' => [
            'addsubscription',
            'postaddsubscription',
            'getupdatesubscription',
            'postupdatesubscription',
            'destroysubscription'
        ]
    ]);



    /*# blog test_mail
        Route::get('test_mail', [
            'uses' => "Admin\SubscriptionsController@test_mail",
            'as' => 'addsubscripti',
            'title' => __('pages.add-new-subscription'),
        ]);
        */

    # blog add
    Route::get('create', [
        'uses' => "Admin\SubscriptionsController@create",
        'as' => 'addsubscription',
        'title' => __('pages.add-new-subscription'),
    ]);


    # blog postadd
    Route::post('post-subscription', [
        'uses' => 'Admin\SubscriptionsController@store',
        'as' => 'postaddsubscription',
        'title' => __('pages.store-subscription'),
    ]);

    # blog update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\SubscriptionsController@edit',
        'as' => 'getupdatesubscription',
        'title' => __('pages.edit-subscription'),
    ]);

    # blog postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\SubscriptionsController@update',
        'as' => 'postupdatesubscription',
        'title' => __('pages.update-subscription'),
    ]);

    # blog delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\SubscriptionsController@destroy',
        'as' => 'destroysubscription',
        'title' => __('pages.delete-subscription'),
    ]);
});

// setting group
Route::group(['prefix' => 'site_setting', 'middleware' => ['auth', 'checkRole']], function () {
    # setting page
    Route::get('/', [
        'uses' => 'Admin\SiteSettingController@index',
        'as' => 'site_setting',
        'title' => __('pages.site_setting'),
        'child' => [
            'updateSiteSetting',
            'contact_messages',
            'consultations'
        ]
    ]);

    # update first tap
    Route::post('update', [
        'uses' => 'Admin\SiteSettingController@update',
        'as' => 'updateSiteSetting',
        'title' => __('pages.update-site-setting'),
    ]);
});

// pages group
Route::group(['prefix' => 'pages', 'middleware' => ['auth', 'checkRole']], function () {

    # pages index
    Route::get('/', [
        'uses' => 'Admin\PageController@index',
        'as' => 'pages',
        'title' => __('pages.pages'),
        'child' => [
            //                'addpages',
            //                'postaddpages',
            'getupdatepages',
            'postupdatepages',
            //                'destroypages'
        ]
    ]);

    # pages add
    /*Route::get('create', [
            'uses' => "Admin\PageController@create",
            'as' => 'addpages',
            'title' => __('pages.add-new-page'),
        ]);

        # pages postadd
        Route::post('post-page', [
            'uses' => 'Admin\PageController@store',
            'as' => 'postaddpages',
            'title' => __('pages.store-page'),
        ]);*/

    # pages update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\PageController@edit',
        'as' => 'getupdatepages',
        'title' => __('pages.edit-page'),
    ]);

    # pages postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\PageController@update',
        'as' => 'postupdatepages',
        'title' => __('pages.update-page'),
    ]);

    # pages delete
    /*Route::get('/delete/{id}', [
            'uses' => 'Admin\PageController@destroy',
            'as' => 'destroypages',
            'title' => __('pages.delete-page'),
        ]);*/
});

// contact_messages group
Route::group(['prefix' => 'contact_messages', 'middleware' => ['auth', 'checkRole']], function () {
    # contact_messages index
    Route::get('/', [
        'uses' => 'HomeController@contactMessages',
        'as' => 'contact_messages',
        'title' => __('pages.contact_messages'),
    ]);
});

// consultations group
Route::group(['prefix' => 'consultations', 'middleware' => ['auth', 'checkRole']], function () {
    # consultations index
    Route::get('/', [
        'uses' => 'HomeController@consultations',
        'as' => 'consultations',
        'title' => __('pages.consultations'),
    ]);
});

Route::post('consultations/reply', 'HomeController@consultationReply');
Route::get('consultations/show/{id}', 'HomeController@consultationShow');
Route::post('consultations/suggested_date_action', 'HomeController@consultationSuggestedAction');

// testimonials group
Route::group(['prefix' => 'testimonials', 'middleware' => ['auth', 'checkRole']], function () {

    # testimonials index
    Route::get('/', [
        'uses' => 'Admin\TestimonialController@index',
        'as' => 'testimonials',
        'title' => __('pages.testimonials'),
        'child' => [
            'addtestimonials',
            'postaddtestimonials',
            'getupdatetestimonials',
            'postupdatetestimonials',
            'destroytestimonials'
        ]
    ]);

    # testimonials add
    Route::get('create', [
        'uses' => "Admin\TestimonialController@create",
        'as' => 'addtestimonials',
        'title' => __('pages.add-new-testimonial'),
    ]);

    # testimonials postadd
    Route::post('post-testimonial', [
        'uses' => 'Admin\TestimonialController@store',
        'as' => 'postaddtestimonials',
        'title' => __('pages.store-testimonial'),
    ]);

    # testimonials update
    Route::get('/edit/{id}', [
        'uses' => 'Admin\TestimonialController@edit',
        'as' => 'getupdatetestimonials',
        'title' => __('pages.edit-testimonial'),
    ]);

    # testimonials postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Admin\TestimonialController@update',
        'as' => 'postupdatetestimonials',
        'title' => __('pages.update-testimonial'),
    ]);

    # testimonials delete
    Route::get('/delete/{id}', [
        'uses' => 'Admin\TestimonialController@destroy',
        'as' => 'destroytestimonials',
        'title' => __('pages.delete-testimonial'),
    ]);
});

// newsletters group
Route::group(['prefix' => 'newsletters', 'middleware' => ['auth', 'checkRole']], function () {

    # newsletters index
    Route::get('/', [
        'uses' => 'HomeController@newsletters',
        'as' => 'newsletters',
        'title' => __('pages.newsletters'),
        'child' => [
            'postaddnewsletters'
        ]
    ]);

    # newsletters postadd
    Route::post('post-newsletter', [
        'uses' => 'HomeController@newslettersContact',
        'as' => 'postaddnewsletters',
        'title' => __('pages.store-newsletter'),
    ]);
});

Route::group(['prefix' => 'trainer', 'middleware' => ['auth', 'checkRole']], function () {

    Route::group(['prefix' => 'courses', 'middleware' => ['auth', 'checkRole']], function () {

        # courses index
        Route::get('/', [
            'uses' => 'Trainer\CoursesController@index',
            'as' => 'TrainerCourses',
            'title' => __('pages.courses'),
            'child' => [
                'addcoursesTrainer',
                'postaddcoursesTrainer',
                'getupdatecoursesTrainer',
                'postupdatecoursesTrainer',
                'destroycoursesTrainer',
                'DatatableUsersCoursesTrainer',
                'DatatableCoursesGroupsTrainer',
                'destroyUserFromListTrainer',
                'addUserFromListTrainer',
                'destroyGroupFromListTrainer',
                'addGroupFromListTrainer',
                'showAllTrainer'
            ]
        ]);

        # courses add
        Route::get('create', [
            'uses' => "Trainer\CoursesController@create",
            'as' => 'addcoursesTrainer',
            'title' => __('pages.create-course'),
        ]);

        Route::get('show-all/{id}', [
            'uses' => "Trainer\CoursesController@show",
            'as' => 'showAllTrainer',
            'title' => __('pages.show-all-course'),
        ]);

        # courses postadd
        Route::post('post-course', [
            'uses' => 'Trainer\CoursesController@store',
            'as' => 'postaddcoursesTrainer',
            'title' => __('pages.store-course'),
        ]);

        # courses update
        Route::get('/edit/{id}', [
            'uses' => 'Trainer\CoursesController@edit',
            'as' => 'getupdatecoursesTrainer',
            'title' => __('pages.edit-course'),
        ]);

        # courses postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Trainer\CoursesController@update',
            'as' => 'postupdatecoursesTrainer',
            'title' => __('pages.update-course'),
        ]);

        # courses delete
        Route::get('/delete/{id}', [
            'uses' => 'Trainer\CoursesController@destroy',
            'as' => 'destroycoursesTrainer',
            'title' => __('pages.delete-course'),
        ]);

        # users groups datatable
        Route::get('/datatable-users/{id}', [
            'uses' => 'Trainer\CoursesController@DatatableUsersCourses',
            'as' => 'DatatableUsersCoursesTrainer',
            'title' => __('pages.show-user-course'),
        ]);

        # users groups datatable
        Route::get('/datatable-groups/{id}', [
            'uses' => 'Trainer\CoursesController@DatatableCoursesGroups',
            'as' => 'DatatableCoursesGroupsTrainer',
            'title' => __('pages.show-group-relate-course'),
        ]);


        Route::get('/destroy-courseFrom-List/{user_id}/{course_id}', [
            'uses' => 'Trainer\CoursesController@destroyUserFromList',
            'as' => 'destroyUserFromListTrainer',
            'title' => __('pages.delete-user-from-course'),
        ]);


        Route::get('/add-courseFrom-List/{user_id}/{course_id}', [
            'uses' => 'Trainer\CoursesController@addUserFromList',
            'as' => 'addUserFromListTrainer',
            'title' => __('pages.add-user-to-course'),
        ]);


        Route::get('/destroy-groupFrom-List/{group_id}/{course_id}', [
            'uses' => 'Trainer\CoursesController@destroyGroupFromList',
            'as' => 'destroyGroupFromListTrainer',
            'title' => __('pages.delete-group-from-course'),
        ]);


        Route::get('/add-groupFrom-List/{group_id}/{course_id}', [
            'uses' => 'Trainer\CoursesController@addGroupFromList',
            'as' => 'addGroupFromListTrainer',
            'title' => __('pages.add-group-to-course'),
        ]);
    });

    Route::group(['prefix' => 'missions', 'middleware' => ['auth', 'checkRole']], function () {
        # missions
        Route::get('/', [
            'uses' => 'Trainer\MissionController@index',
            'as' => 'TrainerMissions',
            'title' => __('pages.missions'),
            'child' => [
                'addmissionsTrainer',
                'postaddmissionsTrainer',
                'TrainerMissionsReplies',
                'TrainerMissionsShowReply',
                'TrainerMissionsUpdateReply'
            ]
        ]);

        # missions add
        Route::get('/create', [
            'uses' => "Trainer\MissionController@create",
            'as' => 'addmissionsTrainer',
            'title' => __('pages.create-mission'),
        ]);

        # missions postadd
        Route::post('/post-mission', [
            'uses' => 'Trainer\MissionController@store',
            'as' => 'postaddmissionsTrainer',
            'title' => __('pages.store-mission'),
        ]);

        # missions replies
        Route::get('/replies/{id}', [
            'uses' => 'Trainer\MissionController@replies',
            'as' => 'TrainerMissionsReplies',
            'title' => __('pages.missions-replies'),
        ]);

        # missions view replies
        Route::get('/show-reply/{id}', [
            'uses' => 'Trainer\MissionController@showReply',
            'as' => 'TrainerMissionsShowReply',
            'title' => __('pages.missions-show-reply'),
        ]);

        # missions view replies
        Route::post('/update-reply/{id}', [
            'uses' => 'Trainer\MissionController@updateReply',
            'as' => 'TrainerMissionsUpdateReply',
            'title' => __('pages.missions-update-reply'),
        ]);
    });

    Route::group(['prefix' => 'surveys/{courseId}', 'middleware' => ['auth', 'checkRole']], function () {
        # surveys
        Route::get('/', [
            'uses' => 'Trainer\SurveyController@index',
            'as' => 'TrainerSurveys',
            'title' => __('pages.surveys'),
            'child' => [
                'addsurveysTrainer',
                'postaddsurveysTrainer',
                'editsurveysTrainer',
                'updatesurveysTrainer',
                'TrainerSurveysResults'
            ]
        ]);

        # surveys add
        Route::get('/create', [
            'uses' => "Trainer\SurveyController@create",
            'as' => 'addsurveysTrainer',
            'title' => __('pages.create-survey'),
        ]);

        # surveys postadd
        Route::post('/post-survey', [
            'uses' => 'Trainer\SurveyController@store',
            'as' => 'postaddsurveysTrainer',
            'title' => __('pages.store-survey'),
        ]);

        # surveys edit
        Route::get('/edit/{id}', [
            'uses' => "Trainer\SurveyController@edit",
            'as' => 'editsurveysTrainer',
            'title' => __('pages.edit-survey'),
        ]);

        # surveys update
        Route::post('/update-survey/{id}', [
            'uses' => 'Trainer\SurveyController@update',
            'as' => 'updatesurveysTrainer',
            'title' => __('pages.update-survey'),
        ]);

        # surveys results
        Route::get('/results/{id}', [
            'uses' => 'Trainer\SurveyController@results',
            'as' => 'TrainerSurveysResults',
            'title' => __('pages.surveys-results'),
        ]);
    });

    Route::group(['prefix' => 'groups', 'middleware' => ['auth', 'checkRole']], function () {

        # groups index
        Route::get('/', [
            'uses' => 'Trainer\GroupsController@index',
            'as' => 'TrainerGroups',
            'title' => __('pages.groups'),
            'child' => [
                'addgroupsTrainer',
                'postaddgroupsTrainer',
                'getupdategroupsTrainer',
                'postupdategroupsTrainer',
                'destroygroupsTrainer',
                'DatatableUsersGroupsTrainer',
                'destroyGroupFromListTrainer',
                'addGroupFromListTrainer',
                'DatatableCoursesGroupsTrainer',
                'destroyCourseFromListTrainer',
                'addCourseFromListTrainer',
                'postaddgroupsfileTrainer',
                'DatatableUsersFilesTrainer',
                'destroyfileTrainer'
            ]
        ]);

        # groups add
        Route::get('create', [
            'uses' => "Trainer\GroupsController@create",
            'as' => 'addgroupsTrainer',
            'title' => __('pages.add-group'),
        ]);

        # groups postadd
        Route::post('post-group', [
            'uses' => 'Trainer\GroupsController@store',
            'as' => 'postaddgroupsTrainer',
            'title' => __('pages.store-group'),
        ]);

        # groups update
        Route::get('/edit/{id}', [
            'uses' => 'Trainer\GroupsController@edit',
            'as' => 'getupdategroupsTrainer',
            'title' => __('pages.edit-group'),
        ]);

        # groups postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Trainer\GroupsController@update',
            'as' => 'postupdategroupsTrainer',
            'title' => __('pages.update-group'),
        ]);

        # groups delete
        Route::get('/delete/{id}', [
            'uses' => 'Trainer\GroupsController@destroy',
            'as' => 'destroygroupsTrainer',
            'title' => __('pages.delete-group'),
        ]);


        # users groups datatable
        Route::get('/datatable-users/{id}', [
            'uses' => 'Trainer\GroupsController@DatatableUsersGroups',
            'as' => 'DatatableUsersGroupsTrainer',
            'title' => __('pages.show-user-relate-group'),
        ]);


        Route::get('/destroy-groupFrom-List/{group_id}/{student_id}', [
            'uses' => 'Trainer\GroupsController@destroyGroupFromList',
            'as' => 'destroyGroupFromListTrainer',
            'title' => __('pages.delete-user-from-group'),
        ]);


        Route::get('/add-groupFrom-List/{group_id}/{student_id}', [
            'uses' => 'Trainer\GroupsController@addGroupFromList',
            'as' => 'addGroupFromListTrainer',
            'title' => __('pages.add-user-to-group'),
        ]);


        //courses groups datatable
        Route::get('/datatable-courses/{id}', [
            'uses' => 'Trainer\GroupsController@DatatableCoursesGroups',
            'as' => 'DatatableCoursesGroupsTrainer',
            'title' => __('pages.show-course-relate-group'),
        ]);


        Route::get('/destroy-courseFrom-List/{group_id}/{course_id}', [
            'uses' => 'Trainer\GroupsController@destroyCourseFromList',
            'as' => 'destroyCourseFromListTrainer',
            'title' => __('pages.delete-course-from-group'),
        ]);


        Route::get('/add-courseFrom-List/{group_id}/{course_id}', [
            'uses' => 'Trainer\GroupsController@addCourseFromList',
            'as' => 'addCourseFromListTrainer',
            'title' => __('pages.add-course-to-group'),
        ]);


        # users postadd
        Route::post('post-file-upload/{group_id}', [
            'uses' => 'Trainer\GroupsController@uploadFile',
            'as' => 'postaddgroupsfileTrainer',
            'title' => __('pages.add-file-form-group'),
        ]);


        # groups files datatable
        Route::get('/datatable-files/{id}', [
            'uses' => 'Trainer\GroupsController@DatatableUsersFiles',
            'as' => 'DatatableUsersFilesTrainer',
            'title' => __('pages.show-file-form-group'),
        ]);

        # files delete
        Route::get('/delete-file/{id}', [
            'uses' => 'Trainer\GroupsController@destroyFile',
            'as' => 'destroyfileTrainer',
            'title' => __('pages.delete-files'),
        ]);
    });

    Route::group(['prefix' => 'meeting', 'middleware' => ['auth', 'checkRole']], function () {

        # groups index
        Route::get('/', [
            'uses' => 'Trainer\MeetingsController@index',
            'as' => 'TrainerMeeting',
            'title' => __('pages.meetings'),
            'child' => [
                'addmeetingTrainer',
                'postaddmeetingTrainer',
                'getupdatemeetingTrainer',
                'postupdatemeetingTrainer',
                'destroymeetingTrainer',
                'ajaxshowmeetingTrainer',
                'startmeetingTrainer'
            ]
        ]);

        # groups add
        Route::get('create', [
            'uses' => "Trainer\MeetingsController@create",
            'as' => 'addmeetingTrainer',
            'title' => __('pages.add-new-meeting'),
        ]);

        # groups postadd
        Route::post('post-group', [
            'uses' => 'Trainer\MeetingsController@store',
            'as' => 'postaddmeetingTrainer',
            'title' => __('pages.store-meeting'),
        ]);

        # groups update
        Route::get('/edit/{id}', [
            'uses' => 'Trainer\MeetingsController@edit',
            'as' => 'getupdatemeetingTrainer',
            'title' => __('pages.edit-meeting'),
        ]);
        Route::get('/ajaxShow/{id}', [
            'uses' => 'Trainer\MeetingsController@ajaxShow',
            'as' => 'ajaxshowmeetingTrainer',
            'title' => __('pages.show-meeting'),
        ]);
        # groups postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Trainer\MeetingsController@update',
            'as' => 'postupdatemeetingTrainer',
            'title' => __('pages.update-meeting'),
        ]);

        # groups delete
        Route::get('/delete/{id}', [
            'uses' => 'Trainer\MeetingsController@destroy',
            'as' => 'destroymeetingTrainer',
            'title' => __('pages.delete-meeting'),
        ]);

        # groups start
        Route::get('/start/{id}', [
            'uses' => 'Trainer\MeetingsController@start',
            'as' => 'startmeetingTrainer',
            'title' => __('pages.start-meeting'),
        ]);
    });

    Route::group(['prefix' => 'events', 'middleware' => ['auth', 'checkRole']], function () {

        # event index
        Route::get('/', [
            'uses' => 'Trainer\EventsController@index',
            'as' => 'TrainerEvents',
            'title' => __('pages.events'),
            'child' => [
                'addeventTrainer',
                'postaddeventTrainer',
                'getupdateeventTrainer',
                'postupdateeventTrainer',
                'destroyeventTrainer',
                'ajaxupdateeventTrainer',
            ]
        ]);


        Route::post('appointments_ajax_update/{id}', [
            'uses' => 'Trainer\EventsController@ajaxUpdate',
            'as' => 'ajaxupdateeventTrainer',
            'title' => __('pages.update-event')
        ]);

        # event add
        Route::get('create', [
            'uses' => "Trainer\EventsController@create",
            'as' => 'addeventTrainer',
            'title' => __('pages.add-event'),
        ]);

        # event postadd
        Route::post('post-event-trainer', [
            'uses' => 'Trainer\EventsController@store',
            'as' => 'postaddeventTrainer',
            'title' => __('pages.store-event'),
        ]);

        # event update
        Route::get('/edit/{id}', [
            'uses' => 'Trainer\EventsController@edit',
            'as' => 'getupdateeventTrainer',
            'title' => __('pages.edit-event'),
        ]);

        # event postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Trainer\EventsController@update',
            'as' => 'postupdateeventTrainer',
            'title' => __('pages.update-event'),
        ]);

        # event delete
        Route::get('/delete/{id}', [
            'uses' => 'Trainer\EventsController@destroy',
            'as' => 'destroyeventTrainer',
            'title' => __('pages.delete-event'),
        ]);
    });

    Route::group(['prefix' => 'lessons', 'middleware' => ['auth', 'checkRole']], function () {

        # groups index
        Route::get('/', [
            'uses' => 'Trainer\CoursesLessonsController@index',
            'as' => 'TrainerLessons',
            'title' => __('pages.lessons'),
            'child' => [
                'addlessonsTrainer',
                'showLessonTrainer',
                'postaddlessonsTrainer',
                'getupdatelessonsTrainer',
                'postupdatelessonsTrainer',
                'destroylessonsTrainer',
                'TrainerDatatableUsersCoursesLesson',
                'postaddlessonsTramsTrainer'
            ]
        ]);


        Route::get('/datatable-users-lesson/{id}', [
            'uses' => 'Trainer\CoursesLessonsController@DatatableUsersCourses',
            'as' => 'TrainerDatatableUsersCoursesLesson',
            'title' => __('pages.show-lesson-course'),
        ]);


        # lessons add
        Route::get('create/{id}', [
            'uses' => "Trainer\CoursesLessonsController@create",
            'as' => 'addlessonsTrainer',
            'title' => __('pages.add-lessons'),
        ]);

        # lessons show
        Route::get('show/{id}', [
            'uses' => "Trainer\CoursesLessonsController@show",
            'as' => 'showLessonTrainer',
            'title' => __('pages.show-lesson-course'),
        ]);

        # lessons postadd
        Route::post('post-lesson', [
            'uses' => 'Trainer\CoursesLessonsController@store',
            'as' => 'postaddlessonsTrainer',
            'title' => __('pages.store-lessons'),
        ]);


        # lessons postadd
        Route::post('post-lesson-terms/{id}', [
            'uses' => 'Trainer\CoursesLessonsController@trams',
            'as' => 'postaddlessonsTramsTrainer',
            'title' => __('pages.store-lessons-terms'),
        ]);


        # lessons edit
        Route::get('/edit/{course_id}/{lesson_id}', [
            'uses' => 'Trainer\CoursesLessonsController@edit',
            'as' => 'getupdatelessonsTrainer',
            'title' => __('pages.edit-lessons'),
        ]);

        # lessons postupdate
        Route::post('postupdate/{course_id}/{lesson_id}', [
            'uses' => 'Trainer\CoursesLessonsController@update',
            'as' => 'postupdatelessonsTrainer',
            'title' => __('pages.update-lessons'),
        ]);
    });

    /*Route::group(['prefix' => 'blue-test', 'middleware' => ['auth', 'checkRole']], function () {

        # groups index
        Route::get('all', [
            'uses' => 'Trainer\TestMeetings@all',
            'as' => 'meetingTest',
            'title' => __('pages.meetingTest'),
            'child' => [
                'addTestmeetingTrainer',
                'joinTestmeetingTrainer',
                'closeTestmeetingTrainer',
            ]
        ]);


        # groups add
        Route::get('create', [
            'uses' => "Trainer\TestMeetings@create",
            'as' => 'addTestmeetingTrainer',
            'title' => __('pages.add-meet-test'),
        ]);
        # groups add
        Route::get('join/{id}', [
            'uses' => "Trainer\TestMeetings@join",
            'as' => 'joinTestmeetingTrainer',
            'title' => __('pages.join-meet-test'),
        ]);

        Route::get('close', [
            'uses' => "Trainer\TestMeetings@close",
            'as' => 'closeTestmeetingTrainer',
            'title' => __('pages.close-meet-test'),
        ]);

    });*/

    Route::group(['prefix' => 'discussions', 'middleware' => ['auth', 'checkRole']], function () {

        # courses index
        Route::get('/', [
            'uses' => 'Trainer\DiscussionsController@index',
            'as' => 'TrainerDiscussions',
            'title' => __('pages.discussions'),
            'child' => [
                'adddiscussionsTrainer',
                'storediscussionTrainer',
                'destroydiscussionTrainer',
                'getupdatediscussionTrainer',
                'postupdatediscussionTrainer',
                'showdiscussionTrainer',
                'addcommentdiscussionTrainer'
            ]
        ]);

        # courses add
        Route::get('create', [
            'uses' => "Trainer\DiscussionsController@create",
            'as' => 'adddiscussionsTrainer',
            'title' => __('pages.add-discussions'),
        ]);

        # store discussion
        Route::post('post-discussion-trainer', [
            'uses' => 'Trainer\DiscussionsController@store',
            'as' => 'storediscussionTrainer',
            'title' => __('pages.store-discussions'),
        ]);

        # edit discussion
        Route::get('/edit/{id}', [
            'uses' => 'Trainer\DiscussionsController@edit',
            'as' => 'getupdatediscussionTrainer',
            'title' => __('pages.edit-discussion'),
        ]);

        # update discussion
        Route::post('postupdate', [
            'uses' => 'Trainer\DiscussionsController@update',
            'as' => 'postupdatediscussionTrainer',
            'title' => __('pages.update-discussion'),
        ]);

        # show discussion
        Route::get('show/{id}', [
            'uses' => 'Trainer\DiscussionsController@show',
            'as' => 'showdiscussionTrainer',
            'title' => __('pages.show-discussion'),
        ]);

        # add comment
        Route::get('add-comment/{user_id}/{comment}/{discussion_id}', [
            'uses' => 'Trainer\DiscussionsController@AddComment',
            'as' => 'addcommentdiscussionTrainer',
            'title' => __('pages.add-discussion-comment'),
        ]);

        # delete discussion
        Route::get('/delete/{id}', [
            'uses' => 'Trainer\DiscussionsController@destroy',
            'as' => 'destroydiscussionTrainer',
            'title' => __('pages.delete-discussion'),
        ]);
    });

    Route::group(['prefix' => 'notifications', 'middleware' => ['auth', 'checkRole']], function () {

        # courses index
        Route::get('/', [
            'uses' => 'Trainer\NotificationsController@index',
            'as' => 'TrainerNotifications',
            'title' => __('pages.traner-notifications'),
            'child' => [
                'sendnotificationTrainer'
            ]
        ]);

        # send notification
        Route::post('postnotification', [
            'uses' => 'Trainer\NotificationsController@Send',
            'as' => 'sendnotificationTrainer',
            'title' => __('pages.send-notification'),
        ]);
    });
});


Route::group(['prefix' => 'student', 'middleware' => ['auth', 'checkRole']], function () {

    # users update
    Route::get('edit', [
        'uses' => 'Student\StudentController@edit',
        'as' => 'getUpdateStudent',
        'title' => __('pages.edit-user'),
    ]);
    # users postupdate
    Route::post('postupdate/{id}', [
        'uses' => 'Student\StudentController@update',
        'as' => 'postUpdateStudent',
        'title' => __('pages.update-user'),
    ]);

    Route::group(['prefix' => 'courses', 'middleware' => ['auth', 'checkRole']], function () {

        # courses index
        Route::get('/', [
            'uses' => 'Student\CoursesController@index',
            'as' => 'StudentCourses',
            'title' => __('pages.courses'),
            'child' => [
                'StudentCatalogJoinCourse',
                'StudentCatalog',
                'showCourseDetailsStudent',
                'showLessonStudent',
                'finishLessonStudent',
                'showSurveysStudent',
                'answerSurveysStudent',
                'showSurveyResultsStudent'
            ]
        ]);

        Route::post('catalog/join_course', [
            'uses' => 'Student\CoursesController@joinCourse',
            'as' => 'StudentCatalogJoinCourse',
            'title' => __('pages.courses_catalog'),
        ]);

        Route::get('catalog/{id?}', [
            'uses' => 'Student\CoursesController@catalog',
            'as' => 'StudentCatalog',
            'title' => __('pages.courses_catalog'),
        ]);

        Route::get('subscripe/{id?}', [
            'uses' => 'Student\CoursesController@subscripe',
            'as' => 'StudentSubscription',
            'title' => __('pages.subscription'),
        ]);

        Route::post('postsubscripe', [
            'uses' => 'Student\SubscriptionsController@store',
            'as' => 'postaddstudentsubscription',
        ]);
        /*Route::get('course_details/{id}', [
            'uses' => 'Student\CoursesController@courseDetails',
            'as' => 'StudentCourseDetails',
            'title' => __('pages.courses_course_details'),
        ]);*/

        Route::get('show/{id}', [
            'uses' => "Student\CoursesController@show",
            'as' => 'showCourseDetailsStudent',
            'title' => __('pages.show-all-course'),
        ]);


        Route::get('show-lesson/{id}', [
            'uses' => "Student\CoursesController@showLesson",
            'as' => 'showLessonStudent',
            'title' => __('pages.show-lesson-course'),
        ]);

        Route::post('finish_lesson', [
            'uses' => "Student\CoursesController@finishLesson",
            'as' => 'finishLessonStudent',
            'title' => __('pages.finish-lesson-course'),
        ]);

        # surveys show
        Route::get('/show-survey/{id}', [
            'uses' => "Student\CoursesController@showSurvey",
            'as' => 'showSurveysStudent',
            'title' => __('pages.show-survey'),
        ]);

        # answer survey
        Route::post('/answer-survey/{id}', [
            'uses' => 'Student\CoursesController@answerSurvey',
            'as' => 'answerSurveysStudent',
            'title' => __('pages.surveys-answer'),
        ]);

        # surveys show
        Route::get('/show-survey-results/{id}', [
            'uses' => "Student\CoursesController@showSurveyResults",
            'as' => 'showSurveyResultsStudent',
            'title' => __('pages.surveys-results'),
        ]);
    });

    Route::group(['prefix' => 'groups', 'middleware' => ['auth', 'checkRole']], function () {

        # groups index
        Route::get('/', [
            'uses' => 'Student\GroupsController@index',
            'as' => 'StudentGroups',
            'title' => __('pages.groups'),
            'child' => [
                'addgroupsStudent',
                'postaddgroupsStudent',
            ]
        ]);

        # groups add
        Route::get('join', [
            'uses' => "Student\GroupsController@showGroup",
            'as' => 'addgroupsStudent',
            'title' => __('pages.join-to-group'),
        ]);


        # group show
        Route::get('show/{id}', [
            'uses' => "Student\GroupsController@show",
            'as' => 'showGroup',
            'title' => __('pages.show-group'),
        ]);

        # groups postadd
        Route::post('post-group', [
            'uses' => 'Student\GroupsController@JoinGroup',
            'as' => 'postaddgroupsStudent',
            'title' => __('pages.store-group'),
        ]);
    });

    Route::group(['prefix' => 'events', 'middleware' => ['auth', 'checkRole']], function () {

        # event index
        Route::get('/', [
            'uses' => 'Student\EventsController@index',
            'as' => 'StudentEvents',
            'title' => __('pages.events'),
            'child' => [
                'addeventStudent',
                'postaddeventStudent',
                'getupdateeventStudent',
                'postupdateeventStudent',
                'destroyeventStudent',
                'ajaxMeetingShowStudent',
            ]
        ]);


        Route::post('appointments_ajax_update', [
            'uses' => 'Student\EventsController@ajaxUpdate',
            'as' => 'appointments.ajax_update'
        ]);

        # event add
        Route::get('create', [
            'uses' => "Student\EventsController@create",
            'as' => 'addeventStudent',
            'title' => __('pages.add-event'),
        ]);

        # event postadd
        Route::post('post-event-trainer', [
            'uses' => 'Student\EventsController@store',
            'as' => 'postaddeventStudent',
            'title' => __('pages.store-event'),
        ]);

        # event update
        Route::get('/edit/{id}', [
            'uses' => 'Student\EventsController@edit',
            'as' => 'getupdateeventStudent',
            'title' => __('pages.edit-event'),
        ]);

        # event update
        Route::get('/ajaxMeetingShow/{id}', [
            'uses' => 'Student\EventsController@ajaxMeetingShow',
            'as' => 'ajaxMeetingShowStudent',
            'title' => __('pages.show-meeting'),
        ]);

        # event postupdate
        Route::post('postupdate/{id}', [
            'uses' => 'Student\EventsController@update',
            'as' => 'postupdateeventStudent',
            'title' => __('pages.update-event'),
        ]);

        # event delete
        Route::get('/delete/{id}', [
            'uses' => 'Student\EventsController@destroy',
            'as' => 'destroyeventStudent',
            'title' => __('pages.delete-event'),
        ]);
    });

    Route::group(['prefix' => 'discussions', 'middleware' => ['auth', 'checkRole']], function () {

        # courses index
        Route::get('/', [
            'uses' => 'Student\DiscussionsController@index',
            'as' => 'StudentDiscussions',
            'title' => __('pages.discussions'),
            'child' => [
                'adddiscussionsStudent',
                'storediscussionStudent',
                'destroydiscussionStudent',
                'getupdatediscussionStudent',
                'postupdatediscussionStudent',
                'showdiscussionStudent',
                'addcommentdiscussionStudent'
            ]
        ]);

        # courses add
        Route::get('create', [
            'uses' => "Student\DiscussionsController@create",
            'as' => 'adddiscussionsStudent',
            'title' => __('pages.add-discussions'),
        ]);

        # store discussion
        Route::post('post-discussion-student', [
            'uses' => 'Student\DiscussionsController@store',
            'as' => 'storediscussionStudent',
            'title' => __('pages.store-discussions'),
        ]);

        # edit discussion
        Route::get('/edit/{id}', [
            'uses' => 'Student\DiscussionsController@edit',
            'as' => 'getupdatediscussionStudent',
            'title' => __('pages.edit-discussion'),
        ]);

        # update discussion
        Route::post('postupdate', [
            'uses' => 'Student\DiscussionsController@update',
            'as' => 'postupdatediscussionStudent',
            'title' => __('pages.update-discussion'),
        ]);

        # show discussion
        Route::get('show/{id}', [
            'uses' => 'Student\DiscussionsController@show',
            'as' => 'showdiscussionStudent',
            'title' => __('pages.show-discussion'),
        ]);

        # add comment
        Route::get('add-comment/{user_id}/{comment}/{discussion_id}', [
            'uses' => 'Student\DiscussionsController@AddComment',
            'as' => 'addcommentdiscussionStudent',
            'title' => __('pages.add-discussion-comment'),
        ]);

        # delete discussion
        Route::get('/delete/{id}', [
            'uses' => 'Student\DiscussionsController@destroy',
            'as' => 'destroydiscussionStudent',
            'title' => __('pages.delete-discussion'),
        ]);
    });

    Route::group(['prefix' => 'missions', 'middleware' => ['auth', 'checkRole']], function () {
        # missions
        Route::get('/', [
            'uses' => 'Student\MissionController@index',
            'as' => 'StudentMissions',
            'title' => __('pages.missions'),
            'child' => [
                'showMissionsStudent',
                'StudentMissionsAddReply'
            ]
        ]);

        # missions show
        Route::get('/show/{id}', [
            'uses' => "Student\MissionController@show",
            'as' => 'showMissionsStudent',
            'title' => __('pages.view-mission'),
        ]);

        # missions add reply
        Route::post('/add-reply/{id}', [
            'uses' => 'Student\MissionController@addReply',
            'as' => 'StudentMissionsAddReply',
            'title' => __('pages.missions-add-reply'),
        ]);
    });
});

Route::get('downloader/file', function () {
    $file = request()->filename;
    $fileExt = explode(".", $file)[-1];
    return $fileExt;
    Response::download($file, time() . '.' . $fileExt);
})->name('downloader');