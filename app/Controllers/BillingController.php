<?php
declare(strict_types=1);

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
     * Accepts an array of meter data (as associative arrays),
     * converts them to MeterData objects, and calculates the bill.
     * @throws \DateMalformedStringException
     */
    public function calculateBill(array $meterDataArray): float
    {
        $meterDataObjects = array_map(function ($data) {
            return new MeterData(
                (int)$data['meter_id'],
                new \DateTime($data['timestamp']),
                (float)$data['reading']
            );
        }, $meterDataArray);

        return $this->billingService->calculateTotalBill($meterDataObjects);
    }

    /**
     * Renders the billing view.
     */
    public function renderBill(float $bill): void
    {
        include __DIR__ . '/../Views/billing_view.php';
    }
}
