<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Services\BillingService;
use App\Services\PeakRateStrategy;
use App\Services\OffPeakRateStrategy;
use App\Models\MeterData;

final class BillingServiceTest extends TestCase
{
    public function testCalculateTotalBill(): void
    {
        $peakStrategy = new PeakRateStrategy(0.20);
        $offPeakStrategy = new OffPeakRateStrategy(0.10);
        $billingService = new BillingService($peakStrategy, $offPeakStrategy, 7, 24);

        $data = [
            new MeterData(1, new \DateTime('2023-10-10T06:00:00'), 100),
            new MeterData(1, new \DateTime('2023-10-10T07:00:00'), 150),
            new MeterData(1, new \DateTime('2023-10-10T23:00:00'), 200),
            new MeterData(1, new \DateTime('2023-10-11T00:00:00'), 250),
        ];

        // Expected: (50 * 0.20) + (50 * 0.20) + (50 * 0.10) = 10 + 10 + 5 = 25
        $this->assertEquals(25.0, $billingService->calculateTotalBill($data));
    }
}
