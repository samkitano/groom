<?php
Route::get('/test', 'Admin\\Api\\UtilController@test');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function()
{
    /** LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get(
        '/',
        'FrontController@home'
    )->name('home');

    Route::get(
        LaravelLocalization::transRoute('routes.lease'),
        'FrontController@lease'
    )->name('lease');

    Route::get(
        LaravelLocalization::transRoute('routes.maintenance'),
        'FrontController@maintenance'
    )->name('maintenance');

    Route::get(
        LaravelLocalization::transRoute('routes.services'),
        'FrontController@services'
    )->name('services');

    Route::get(
        LaravelLocalization::transRoute('routes.faq'),
        'FrontController@faq'
    )->name('faq');

    Route::get(
        LaravelLocalization::transRoute('routes.contact'),
        'FrontController@contact'
    )->name('contact');
});

Auth::routes();

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'auth'
],
    function () {
        Route::get('/', function () {
            return view('admin.vue');
        });

        // ADMIN API
        Route::group([
            'prefix' => 'api',
            'namespace' => 'Api'
        ], function () {
            Route::resource('users', 'UsersController')
                 ->except('edit', 'create');

            Route::delete('logs/delete-all', 'LogsController@destroyAll');
            Route::resource('logs', 'LogsController')
                 ->except('edit', 'create', 'store', 'update');

            Route::get('log-archives-master-exists', 'LogArchivesController@checkMaster');
            Route::delete('log-archives-master', 'LogArchivesController@destroyMaster');
            Route::delete('log-archives/delete-all', 'LogArchivesController@destroyAll');
            Route::resource('log-archives', 'LogArchivesController')
                 ->except('create', 'show', 'edit');

            Route::get('log-download/{log}', 'LogsDownloadController@download');
            Route::get('log-download-master', 'LogsDownloadController@downloadMaster');
            Route::get('log-download-archive/{archive}', 'LogsDownloadController@downloadArchive');

            Route::patch('util/exec', 'UtilController@exec');

            Route::patch('modules/reorder', 'ModulesController@reorder');
            Route::patch('modules/check', 'ModulesController@check');
            Route::delete('modules/delete-orphans', 'ModulesController@destroyOrphans');
            Route::resource('modules', 'ModulesController')
                 ->except('edit', 'create');

            Route::patch('pages/check', 'PagesController@check');
            Route::get('pages/list', 'PagesController@list');
            Route::resource('pages', 'PagesController')
                ->except('edit', 'create');

            Route::get('media/images', 'MediaController@images');
            Route::get('media/url', 'MediaController@url');
            Route::resource('media', 'MediaController')
                ->except('edit', 'create', 'update');
        });

        Route::any('{all}', function () {
            return view('admin.vue');
        })->where(['all' => '.*']);
    }
);
