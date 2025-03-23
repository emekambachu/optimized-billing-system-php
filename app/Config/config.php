<?php
return [
    'peak_rate'   => 0.20,    // Default Cost per kWh during peak hours (Can be in a database table)
    'offpeak_rate'=> 0.10,    // Default Cost per kWh during off-peak hours (Can be in a database table)
    'peak_start'  => '07:00', // Default peak hours start time (Can be in a database table)
    'peak_end'    => '23:59', // Default peak hours end time (Can be in a database table)
];
