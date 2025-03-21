<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\BillingController;
use App\Services\BillingService;
use App\Services\PeakRateStrategy;
use App\Services\OffPeakRateStrategy;

class DIContainer
{
    public static function getBillingController(): BillingController
    {
        $config = include __DIR__ . '/../Config/config.php';

        $peakRate = $config['rates']['peak'];
        $offPeakRate = $config['rates']['off_peak'];
        $peakStart = $config['peak_hours']['start'];
        $peakEnd = $config['peak_hours']['end'];

        $peakStrategy = new PeakRateStrategy($peakRate);
        $offPeakStrategy = new OffPeakRateStrategy($offPeakRate);

        $billingService = new BillingService($peakStrategy, $offPeakStrategy, $peakStart, $peakEnd);
        return new BillingController($billingService);
    }
}
