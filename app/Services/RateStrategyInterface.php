<?php
declare(strict_types=1);

namespace App\Services;

interface RateStrategyInterface
{
    public function getRate(\DateTime $timestamp): float;
}
