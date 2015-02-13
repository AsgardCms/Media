<?php

use Illuminate\Routing\Router;

$router->model('media', 'Modules\Media\Entities\File');

$router->group(['prefix' => '/media'], function (Router $router) {
    $router->resource('media', 'MediaController', [
        'except' => ['show'],
        'names' => [
            'index' => 'admin.media.media.index',
            'create' => 'admin.media.media.create',
            'store' => 'admin.media.media.store',
            'edit' => 'admin.media.media.edit',
            'update' => 'admin.media.media.update',
            'destroy' => 'admin.media.media.destroy',
        ],
    ]);
});

$router->get('grid-files', 'MediaController@gridFiles');
