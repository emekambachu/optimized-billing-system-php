<?php
declare(strict_types=1);

// Stored rates and peak hours in a config file since I'm not using a database
return [
    'rates' => [
        'peak' => 0.20,
        'off_peak' => 0.10,
    ],
    'peak_hours' => [
        'start' => 7,
        'end' => 24,
    ],
];
