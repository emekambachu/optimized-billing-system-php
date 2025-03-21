<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Services\PeakRateStrategy;
use App\Services\OffPeakRateStrategy;

final class RateStrategyTest extends TestCase
{
    public function testPeakRateStrategy(): void
    {
        $peakStrategy = new PeakRateStrategy(0.20);
        $this->assertEquals(0.20, $peakStrategy->getRate(new \DateTime()));
    }

    public function testOffPeakRateStrategy(): void
    {
        $offPeakStrategy = new OffPeakRateStrategy(0.10);
        $this->assertEquals(0.10, $offPeakStrategy->getRate(new \DateTime()));
    }
}
