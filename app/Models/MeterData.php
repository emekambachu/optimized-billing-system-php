<?php
namespace App\Models;

class MeterData
{
    public int $meterId;
    public string $timestamp;
    public float $meterReading;

    public function __construct(int $meterId, string $timestamp, float $meterReading)
    {
        $this->meterId = $meterId;
        $this->timestamp = $timestamp;
        $this->meterReading = $meterReading;
    }
}
