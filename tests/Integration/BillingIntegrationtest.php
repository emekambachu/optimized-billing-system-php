<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\BillingController;
use App\Services\BillingService;

class BillingIntegrationTest extends TestCase
{
    public function testBillingControllerOutputWithUpdatedRates(): void
    {
        // Simulate form submission with new rates.
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['peak_rate'] = '0.30';
        $_POST['offpeak_rate'] = '0.15';

        ob_start();
        $billingService = new BillingService(0.20, 0.10, '07:00', '23:59');
        $controller = new BillingController($billingService);
        $controller->calculateBill();
        $output = ob_get_clean();

        // Verify that the updated values are rendered in the form.
        $this->assertStringContainsString('value="0.30"', $output);
        $this->assertStringContainsString('value="0.15"', $output);

        // Optionally, check that the table contains billing data.
        $this->assertStringContainsString('Meter ID', $output);
    }
}
