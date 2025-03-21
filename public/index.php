<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\DIContainer;

// Get the billing controller via dependency injection
$billingController = DIContainer::getBillingController();

// Sample meter data (in a real app, this might come from a database or API)
$sampleMeterData = [
    ['meter_id' => 1, 'timestamp' => '2023-10-10T06:00:00', 'reading' => 100],
    ['meter_id' => 1, 'timestamp' => '2023-10-10T07:00:00', 'reading' => 150],
    ['meter_id' => 1, 'timestamp' => '2023-10-10T23:00:00', 'reading' => 200],
    ['meter_id' => 1, 'timestamp' => '2023-10-11T00:00:00', 'reading' => 250],
];

$bill = $billingController->calculateBill($sampleMeterData);
$billingController->renderBill($bill);
