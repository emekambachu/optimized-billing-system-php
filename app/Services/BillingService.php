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
     * Calculates the total bill for a list of meter readings.
     *
     * @param MeterData[] $meterDataList
     * @return Bill
     */
    public function calculateBill(array $meterDataList): Bill
    {
        $totalCost = 0.0;
        foreach ($meterDataList as $data) {
            // Convert the timestamp to a time string.
            $timestamp = strtotime($data->timestamp);
            $time = date('H:i', $timestamp);
            // Determine rate based on time of day.
            $rate = ($time >= $this->peakStart && $time <= $this->peakEnd)
                ? $this->peakRate
                : $this->offPeakRate;
            // Multiply usage by rate.
            $totalCost += $data->meterReading * $rate;
        }
        return new Bill($totalCost);
    }
}
