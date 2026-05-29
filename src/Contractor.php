<?php

namespace Urssaf;

class Contractor{
    public function __construct(
        private string $fullName,
        private string $siret,
        private string $activity,
        private string $taxSystem,
        private AbstractActivityStrategy $strategy
    ){}

    public function buildReport(float $caHt): string
    {
        $activityLabels = ["bic-ventes" => "BIC Ventes", "bic" => "BIC", "bnc" => "BNC"];
        $taxLabels = ["ps" => "Prélévement à la source", "vfl" => "Versement fiscal libératoire"];
        $header = $this->fullname . " " . $activityLabels[$this->activity] . " " . $taxLabels[$this->taxSystem] . PHP_EOL;
        return $header . $this->strategy->buildReport($caHt, $this->taxSystem);
    }

    public function describe(): string
    {
        return $this->id . " " . $this->fullName . " " . $this->siret . " " . $this->activity . " " . $this->taxSystem;
    }
}