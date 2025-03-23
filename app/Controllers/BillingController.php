<?php
namespace App\Controllers;

use App\Services\BillingService;
use App\Models\MeterData;

class BillingController
{
    private BillingService $billingService;

    public function __construct(BillingService $billingService)
    {
        $this->billingService = $billingService;
    }

    /**
     * Retrieves meter data, updates rates if provided, calculates the bills per meter_id, and renders the view.
     */
    public function calculateBill(): void
    {
        // Check if the form has been submitted.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPeakRate = isset($_POST['peak_rate']) ? (float) $_POST['peak_rate'] : $this->billingService->getPeakRate();
            $newOffPeakRate = isset($_POST['offpeak_rate']) ? (float) $_POST['offpeak_rate'] : $this->billingService->getOffPeakRate();
            $this->billingService->updateRates($newPeakRate, $newOffPeakRate);
        }

        // Example meter data with different meter_id values.
        $meterDataList = [
            // For household with meter_id 1:
            new MeterData(1, '2023-10-10T08:00:00', 150),  // Peak hour
            new MeterData(1, '2023-10-10T01:00:00', 100),  // Off-peak hour

            // For household with meter_id 2:
            new MeterData(2, '2023-10-10T09:00:00', 200),  // Peak hour
            new MeterData(2, '2023-10-10T03:00:00', 80),   // Off-peak hour

            // For household with meter_id 3:
            new MeterData(3, '2023-10-10T22:00:00', 120),  // Peak hour
            new MeterData(3, '2023-10-10T05:00:00', 70)    // Off-peak hour
        ];

        // Calculate bills grouped by meter_id.
        $bills = $this->billingService->calculateBills($meterDataList);

        // Pass the current rates to the view.
        $currentPeakRate = $this->billingService->getPeakRate();
        $currentOffPeakRate = $this->billingService->getOffPeakRate();

        require __DIR__ . '/../Views/billingView.php';
    }
}
