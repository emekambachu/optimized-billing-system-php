<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\MeterData;

class BillingService
{
    private RateStrategyInterface $peakStrategy;
    private RateStrategyInterface $offPeakStrategy;
    private int $peakStart;
    private int $peakEnd;

    public function __construct(
        RateStrategyInterface $peakStrategy,
        RateStrategyInterface $offPeakStrategy,
        int $peakStart = 7,
        int $peakEnd = 24
    ) {
        $this->peakStrategy = $peakStrategy;
        $this->offPeakStrategy = $offPeakStrategy;
        $this->peakStart = $peakStart;
        $this->peakEnd = $peakEnd;
    }

    /**
     * Calculates the total bill from an array of MeterData.
     * It computes usage as the difference between consecutive readings and
     * multiplies by the appropriate rate depending on the hour.
     *
     * @param MeterData[] $meterDataArray
     * @return float
     */
    public function calculateTotalBill(array $meterDataArray): float
    {
        $totalBill = 0.0;
        // Ensure the data is sorted by timestamp
        usort($meterDataArray, function (MeterData $a, MeterData $b) {
            return $a->getTimestamp() <=> $b->getTimestamp();
        });

        // Loop through the readings (starting from the second record)
        for ($i = 1, $n = count($meterDataArray); $i < $n; $i++) {
            $previous = $meterDataArray[$i - 1];
            $current  = $meterDataArray[$i];
            $usage = $current->getReading() - $previous->getReading();

            // Determine if current timestamp falls in peak or off-peak hours
            $hour = (int)$current->getTimestamp()->format('G');
            if ($hour >= $this->peakStart && $hour < $this->peakEnd) {
                $rate = $this->peakStrategy->getRate($current->getTimestamp());
            } else {
                $rate = $this->offPeakStrategy->getRate($current->getTimestamp());
            }

            $totalBill += $usage * $rate;
        }
        return $totalBill;
    }
}
