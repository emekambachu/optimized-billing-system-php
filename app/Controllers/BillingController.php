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
     * Retrieves meter data from a JSON file, updates rates if provided, calculates the bills per meter_id,
     * and renders the view. Catches exceptions to report errors.
     */
    public function calculateBill(): void
    {
        $errorMessage = null;
        try {
            // Update rates if form is submitted.
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['peak_rate'], $_POST['offpeak_rate'])) {

                    // Validate rates
                    $this->billingService->validateRate((float)$_POST['peak_rate']);
                    $this->billingService->validateRate((float)$_POST['offpeak_rate']);

                    $newPeakRate = (float) $_POST['peak_rate'];
                    $newOffPeakRate = (float) $_POST['offpeak_rate'];
                    $this->billingService->updateRates($newPeakRate, $newOffPeakRate);

                } else {
                    throw new \RuntimeException("Rates are not provided.");
                }
            }

            // Load meter data from JSON file (This can be from an API or database,
            // but for this test we are using a JSON file).
            $jsonFilePath = __DIR__ . '/../../data/meterdata.json';
            if (!file_exists($jsonFilePath)) {
                throw new \RuntimeException("Meter data JSON file not found.");
            }

            $jsonData = file_get_contents($jsonFilePath);
            if ($jsonData === false) {
                throw new \RuntimeException("Failed to read meter data JSON file.");
            }

            $dataArray = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);
            if ($dataArray === null) {
                throw new \RuntimeException("Invalid JSON data in meter data file.");
            }

            // Convert JSON records into MeterData objects.
            $meterDataList = [];
            foreach ($dataArray as $record) {
                if (!isset($record['meter_id'], $record['timestamp'], $record['meter_reading'])) {
                    throw new \RuntimeException("Invalid record in meter data file.");
                }
                $meterDataList[] = new MeterData(
                    (int)$record['meter_id'],
                    $record['timestamp'],
                    (float)$record['meter_reading']
                );
            }

            // Calculate bills grouped by meter_id.
            $bills = $this->billingService->calculateBills($meterDataList);
            $currentPeakRate = $this->billingService->getPeakRate();
            $currentOffPeakRate = $this->billingService->getOffPeakRate();

        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();
            $bills = [];
            $currentPeakRate = $this->billingService->getPeakRate();
            $currentOffPeakRate = $this->billingService->getOffPeakRate();

        }

        require __DIR__ . '/../Views/billingView.php';
    }
}
