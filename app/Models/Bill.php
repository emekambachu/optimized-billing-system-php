<?php
namespace App\Models;

class Bill
{
    public float $totalCost;

    public function __construct(float $totalCost)
    {
        $this->totalCost = $totalCost;
    }
}
