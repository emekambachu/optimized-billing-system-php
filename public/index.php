<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\BillingController;
use App\Services\BillingService;

// import default data from config file
$config = require __DIR__ . '/../app/Config/config.php';

$billingService = new BillingService(
    $config['peak_rate'],
    $config['offpeak_rate'],
    $config['peak_start'],
    $config['peak_end']
);
$controller = new BillingController($billingService);
$controller->calculateBill();
