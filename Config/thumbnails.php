<?php

return [
    'smallThumb' => [
        'fit' => [
            'width' => 50,
            'height' => 50,
            'callback' => function ($constraint) {
                $constraint->upsize();
            },
        ],
    ],
    'mediumThumb' => [
        'fit' => [
            'width' => 180,
            'position' => 'top-left',
        ],
    ],
];
