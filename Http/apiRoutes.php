<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->post('file', ['uses' => 'MediaController@store', 'as' => 'api.media.store']);
$router->post('media/link', ['uses' => 'MediaController@linkMedia', 'as' => 'api.media.link']);
$router->post('media/unlink', ['uses' => 'MediaController@unlinkMedia', 'as' => 'api.media.unlink']);
$router->get('media/all', ['uses' => 'MediaController@all', 'as' => 'api.media.all', ]);
$router->post('media/sort', ['uses' => 'MediaController@sortMedia', 'as' => 'api.media.sort']);
