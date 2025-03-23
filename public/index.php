<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\BillingController;
use App\Services\BillingService;

$config = require __DIR__ . '/../config/config.php';

$billingService = new BillingService(
    $config['peak_rate'],
    $config['offpeak_rate'],
    $config['peak_start'],
    $config['peak_end']
);
$controller = new BillingController($billingService);
$controller->calculateBill();
