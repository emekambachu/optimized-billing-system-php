<?php
namespace App\Services;

use App\Models\MeterData;
use App\Models\Bill;

class BillingService
{
    private float $peakRate;
    private float $offPeakRate;
    private string $peakStart;
    private string $peakEnd;

    public function __construct(float $peakRate, float $offPeakRate, string $peakStart = '07:00', string $peakEnd = '23:59')
    {
        $this->peakRate = $peakRate;
        $this->offPeakRate = $offPeakRate;
        $this->peakStart = $peakStart;
        $this->peakEnd = $peakEnd;
    }

    /**
     * Update the billing rates.
     *
     * @param float $peakRate
     * @param float $offPeakRate
     */
    public function updateRates(float $peakRate, float $offPeakRate): void
    {
        if($peakRate < 0 || $offPeakRate < 0) {
            throw new \InvalidArgumentException("Rates cannot be negative.");
        }
        $this->peakRate = $peakRate;
        $this->offPeakRate = $offPeakRate;
    }

    /**
     * Get the current peak rate.
     *
     * @return float
     */
    public function getPeakRate(): float
    {
        return $this->peakRate;
    }

    /**
     * Get the current off-peak rate.
     *
     * @return float
     */
    public function getOffPeakRate(): float
    {
        return $this->offPeakRate;
    }

    /**
     * Calculates the total bills for each meter (household).
     *
     * @param MeterData[] $meterDataList
     * @return array<int, Bill>  Associative array with meter_id as key and Bill as value.
     */
    public function calculateBills(array $meterDataList): array
    {
        $billingAccumulator = [];

        foreach ($meterDataList as $data) {
            $timestamp = strtotime($data->timestamp);
            $time = date('H:i', $timestamp);

            // Determine the rate based on the time.
            $rate = ($time >= $this->peakStart && $time <= $this->peakEnd)
                ? $this->peakRate
                : $this->offPeakRate;

            // Initialize if this meter_id hasn't been encountered.
            if (!isset($billingAccumulator[$data->meterId])) {
                $billingAccumulator[$data->meterId] = 0.0;
            }

            // Accumulate the cost.
            $billingAccumulator[$data->meterId] += $data->meterReading * $rate;
        }

        // Convert to Bill objects.
        return array_map(static function ($totalCost) {
            return new Bill($totalCost);
        }, $billingAccumulator);
    }
}
