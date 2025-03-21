<?php
declare(strict_types=1);

namespace App\Services;

class OffPeakRateStrategy implements RateStrategyInterface
{
    private float $rate;

    public function __construct(float $rate = 0.10)
    {
        $this->rate = $rate;
    }

    public function getRate(\DateTime $timestamp): float
    {
        return $this->rate;
    }
}
