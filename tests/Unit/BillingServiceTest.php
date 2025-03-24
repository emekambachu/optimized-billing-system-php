<?php
use PHPUnit\Framework\TestCase;
use App\Services\BillingService;
use App\Models\MeterData;

class BillingServiceTest extends TestCase
{
    private BillingService $service;
    public function setUp(): void
    {
        $this->service = new BillingService(0.20, 0.10, '07:00', '23:59');

        // Create a simple meter data list.
        $this->meterDataList = [
            // For meter_id 1, one peak and one off-peak reading.
            new MeterData(1, '2023-10-10T08:00:00', 100), // Peak: 100 * 0.30 = 30
            new MeterData(1, '2023-10-10T02:00:00', 50),  // Off-peak: 50 * 0.15 = 7.5

            // For meter_id 2, two peak readings.
            new MeterData(2, '2023-10-10T09:00:00', 200), // Peak: 200 * 0.30 = 60
            new MeterData(2, '2023-10-10T18:00:00', 150), // Peak: 150 * 0.30 = 45

            // For meter_id 3, one off-peak and one peak reading.
            new MeterData(3, '2023-10-10T03:00:00', 80),  // Off-peak: 80 * 0.15 = 12
            new MeterData(3, '2023-10-10T20:00:00', 120), // Peak: 120 * 0.30 = 36

            // For meter_id 4, two off-peak readings.
            new MeterData(4, '2023-10-10T01:00:00', 60),  // Off-peak: 60 * 0.15 = 9
            new MeterData(4, '2023-10-10T05:00:00', 90),  // Off-peak: 90 * 0.15 = 13.5
        ];
    }

    public function testUpdateRatesThrowsExceptionForNegativeValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->updateRates(-0.30, 0.10);
    }

    public function testUpdateRatesAndCalculateBills(): void
    {
        // Update rates.
        $this->service->updateRates(0.30, 0.15);
        $this->assertEquals(0.30, $this->service->getPeakRate());
        $this->assertEquals(0.15, $this->service->getOffPeakRate());

        $bills = $this->service->calculateBills($this->meterDataList);
        $this->assertEquals(37.5, $bills[1]->totalCost);
    }
}
