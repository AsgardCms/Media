<?php

post('file', ['uses' => 'MediaController@store', 'as' => 'api.media.store']);
$router->post('media/link', ['uses' => 'MediaController@linkMedia', 'as' => 'api.media.link']);
$router->post('media/unlink', ['uses' => 'MediaController@unlinkMedia', 'as' => 'api.media.unlink']);
$router->get('media/all', [
    'as' => 'api.media.all',
    'uses' => 'MediaController@all',
]);
