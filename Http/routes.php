<?php

use Illuminate\Routing\Router;

$router->model('media', 'Modules\Media\Entities\File');

$router->group(['prefix' => LaravelLocalization::setLocale(), 'before' => 'LaravelLocalizationRedirectFilter|auth.admin|permissions'], function (Router $router) {
    $router->group(['prefix' => Config::get('core::core.admin-prefix') . '/media', 'namespace' => 'Modules\Media\Http\Controllers'], function (Router $router) {
        $router->resource('media', 'Admin\MediaController', ['except' => ['show'], 'names' => [
                'index' => 'admin.media.media.index',
                'create' => 'admin.media.media.create',
                'store' => 'admin.media.media.store',
                'edit' => 'admin.media.media.edit',
                'update' => 'admin.media.media.update',
                'destroy' => 'admin.media.media.destroy',
            ]]);
    });
});

$router->get('admin/grid-files', 'Modules\Media\Http\Controllers\Admin\MediaController@gridFiles');

$router->group(['prefix' => 'api', 'namespace' => 'Modules\Media\Http\Controllers'], function (Router $router) {
    $router->resource('file', 'Api\MediaController', ['only' => ['store']]);
});
