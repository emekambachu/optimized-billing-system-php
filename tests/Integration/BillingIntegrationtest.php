<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\BillingController;
use App\Services\BillingService;

class BillingIntegrationTest extends TestCase
{
    /**
     * Test that the controller outputs the expected billing results from the JSON file
     * using the default rates.
     *
     * With the sample JSON in /data/meterdata.json and default rates of 0.20 (peak) and 0.10 (off-peak),
     * the expected calculations are:
     *  - Meter ID 1: 150 kWh (peak at 0.20) + 100 kWh (off-peak at 0.10) = 30 + 10 = 40.00
     *  - Meter ID 2: 200 kWh (peak at 0.20) + 80 kWh (off-peak at 0.10) = 40 + 8 = 48.00
     *  - Meter ID 3: 120 kWh (peak at 0.20) + 70 kWh (off-peak at 0.10) = 24 + 7 = 31.00
     */
    public function testBillingControllerOutputUsingDefaultRates(): void
    {
        // Ensure GET request by clearing any POST data.
        $_SERVER['REQUEST_METHOD'] = 'GET';
        unset($_POST['peak_rate'], $_POST['offpeak_rate']);

        ob_start();
        $billingService = new BillingService(0.20, 0.10, '07:00', '23:59');
        $controller = new BillingController($billingService);
        $controller->calculateBill();
        $output = ob_get_clean();

        // Check for expected billing values in the output.
        $this->assertStringContainsString('40.00', $output);
        $this->assertStringContainsString('48.00', $output);
        $this->assertStringContainsString('31.00', $output);
    }

    /**
     * Test that updating rates via a POST request correctly updates the form values and
     * recalculates the billing results.
     *
     * For example, if we update the rates to 0.30 (peak) and 0.15 (off-peak), the expected:
     *  - For Meter ID 1: 150 kWh (peak at 0.30) + 100 kWh (off-peak at 0.15) = 45 + 15 = 60.00
     */
    public function testBillingControllerOutputWithUpdatedRates(): void
    {
        // Simulate a POST request with new rate values.
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

        // With updated rates for Meter ID 1: 150 kWh * 0.30 + 100 kWh * 0.15 = 45 + 15 = 60.00
        $this->assertStringContainsString('60.00', $output);
    }
}
