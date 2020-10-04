<?php

return [

    'modify' => [

        /**
         * Filters config used by \App\Media\Modify\FilterFactory
         */
        'filter' => [
            's' => ['type' => 'crop', 'w' => 400, 'h' => 225],
            'm' => ['type' => 'crop', 'w' => 800, 'h' => 450],
            'l' => ['type' => 'resize', 'w' => 1920, 'h' => 1080],
        ],

    ]

];
