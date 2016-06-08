<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->bind('media', function ($id) {
    return app(\Modules\Media\Repositories\FileRepository::class)->find($id);
});

$router->group(['prefix' => '/media'], function (Router $router) {
    $router->get('media', ['as' => 'admin.media.media.index', 'uses' => 'MediaController@index']);
    $router->get('media/create', ['as' => 'admin.media.media.create', 'uses' => 'MediaController@create']);
    $router->post('media', ['as' => 'admin.media.media.store', 'uses' => 'MediaController@store']);
    $router->get('media/{media}/edit', ['as' => 'admin.media.media.edit', 'uses' => 'MediaController@edit']);
    $router->put('media/{media}', ['as' => 'admin.media.media.update', 'uses' => 'MediaController@update']);
    $router->delete('media/{media}', ['as' => 'admin.media.media.destroy', 'uses' => 'MediaController@destroy']);

    $router->get('media-grid/index', ['uses' => 'MediaGridController@index', 'as' => 'media.grid.select']);
    $router->get('media-grid/ckIndex', ['uses' => 'MediaGridController@ckIndex', 'as' => 'media.grid.ckeditor']);
});
