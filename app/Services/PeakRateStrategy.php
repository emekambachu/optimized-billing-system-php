<?php
declare(strict_types=1);

namespace App\Services;

class PeakRateStrategy implements RateStrategyInterface
{
    private float $rate;

    public function __construct(float $rate = 0.20)
    {
        $this->rate = $rate;
    }

    public function getRate(\DateTime $timestamp): float
    {
        // Could include more complex logic based on timestamp.
        return $this->rate;
    }
}
