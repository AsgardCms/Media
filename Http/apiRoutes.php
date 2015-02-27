<?php

$router->resource('file', 'MediaController', ['only' => ['store']]);
$router->post('media/link', ['uses' => 'MediaController@linkMedia', 'as' => 'api.media.link']);
$router->post('media/unlink', ['uses' => 'MediaController@unlinkMedia', 'as' => 'api.media.unlink']);
