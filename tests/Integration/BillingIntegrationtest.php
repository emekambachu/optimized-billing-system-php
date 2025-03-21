<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\DIContainer;

final class BillingIntegrationTest extends TestCase
{
    public function testBillingIntegration(): void
    {
        $billingController = \App\Core\DIContainer::getBillingController();

        $sampleMeterData = [
            ['meter_id' => 1, 'timestamp' => '2023-10-10T06:00:00', 'reading' => 100],
            ['meter_id' => 1, 'timestamp' => '2023-10-10T07:00:00', 'reading' => 150],
            ['meter_id' => 1, 'timestamp' => '2023-10-10T23:00:00', 'reading' => 200],
            ['meter_id' => 1, 'timestamp' => '2023-10-11T00:00:00', 'reading' => 250],
        ];

        $bill = $billingController->calculateBill($sampleMeterData);
        $this->assertEquals(25.0, $bill);
    }
}
