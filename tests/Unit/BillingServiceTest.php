<?php
use PHPUnit\Framework\TestCase;
use App\Services\BillingService;
use App\Models\MeterData;

class BillingServiceTest extends TestCase
{
    public function testUpdateRatesAndCalculateBills(): void
    {
        $service = new BillingService(0.20, 0.10, '07:00', '23:59');

        // Update rates.
        $service->updateRates(0.30, 0.15);
        $this->assertEquals(0.30, $service->getPeakRate());
        $this->assertEquals(0.15, $service->getOffPeakRate());

        $meterDataList = [
            // For meter_id 1
            new MeterData(1, '2023-10-10T08:00:00', 100), // Peak: 100 * 0.30 = 30
            new MeterData(1, '2023-10-10T02:00:00', 50),  // Off-peak: 50 * 0.15 = 7.5
        ];

        $bills = $service->calculateBills($meterDataList);
        $this->assertEquals(37.5, $bills[1]->totalCost);
    }
}
