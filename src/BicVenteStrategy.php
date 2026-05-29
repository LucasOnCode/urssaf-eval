<?php
namespace Urssaf;

class BicVenteStrategy extends AbstractActivityStrategy
{
    protected function cotisationRate(): float
    {
        return 0.22;
    }

    protected function taxDischargePayment(): float
    {
        return 0.01;
    }

    protected function abatementRate(): float
    {
        return 0.71;
    }

    protected function specificSubsidy(float $caHt): float
    {
        return $caHt > 3000 ? 200 : 0;
    }
}