<?php

post('file', ['uses' => 'MediaController@store', 'as' => 'api.media.store']);
post('media/link', ['uses' => 'MediaController@linkMedia', 'as' => 'api.media.link']);
post('media/unlink', ['uses' => 'MediaController@unlinkMedia', 'as' => 'api.media.unlink']);
get('media/all', ['uses' => 'MediaController@all', 'as' => 'api.media.all', ]);
post('media/sort', ['uses' => 'MediaController@sortMedia', 'as' => 'api.media.sort']);
