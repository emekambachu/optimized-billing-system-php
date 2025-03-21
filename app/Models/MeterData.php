<?php
declare(strict_types=1);

namespace App\Models;

class MeterData
{
    private int $meterId;
    private \DateTime $timestamp;
    private float $reading;

    public function __construct(int $meterId, \DateTime $timestamp, float $reading)
    {
        $this->meterId = $meterId;
        $this->timestamp = $timestamp;
        $this->reading = $reading;
    }

    public function getMeterId(): int
    {
        return $this->meterId;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    public function getReading(): float
    {
        return $this->reading;
    }
}
