<?php

namespace Urssaf;

abstract class AbstractActivityStrategy
{
    public function buildReport(float $caHt, string $taxSystem): string
    {
        $cotisation = $caHt * $this->cotisationRate();
        $subsidy = $this->specificSubsidy($caHt);
        $report = "";
        $report .= "CA HT mensuel :" . number_format($caHt, 2, ' ', ' ') . " Euros" . PHP_EOL;

        if ($subsidy > 0) {
            $report .= "Aide spécifique : " . number_format($subsidy, 2, ' ', ' ') . " Euros" . PHP_EOL;
        }

        $report .= "Cotisations sociales : " . number_format($cotisation, 2, ' ', ' ') . " Euros" . PHP_EOL;

        if ($taxSystem === "ps"){
            $revenueImposable = $caHt * (1 - $this->abatementRate());
            $caTtc = $caHt - $cotisation + $subsidy;
            $report .= "Revenu imposable :" . number_format($revenueImposable, 2, ' ', ' ') . " Euros" . PHP_EOL;
        }else{
            $impôt = $caHt * $this->taxDischargePayment();
            $caTtc = $caHt - $cotisation - $impôt + $subsidy;
            $report .= "Montant impôt :" . number_format($impôt, 2, ' ', ' ') . " Euros" . PHP_EOL;
        }
        $report .= "CA TTC :" . number_format($caTtc, 2, ' ', ' ') . " Euros" . PHP_EOL;

        return $report;
    }
    //Retourne le taux de cotisation social
    abstract protected function cotisationRate(): float;
    //Retourne le taux de prélèvement dans le cadre du régime fiscal "Versement fiscal libératoire" (vfl)
    abstract protected function taxDischargePayment(): float;
    //Retourne le taux d'abattement fiscal dans le cadre du régime fiscal "Prélèvement à la source" (ps)
    abstract protected function abatementRate(): float;

    //De la logique métier propre à chaque régime d'activité
    //Calcul des indemnités de frais d'exploitation
    abstract protected function specificSubsidy(float $caHt): float;
}