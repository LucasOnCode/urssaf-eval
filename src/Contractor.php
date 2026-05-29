<?php

namespace Urssaf;

class Contractor{
    public function __construct(
        private string $fullName,
        private string $siret,
        private string $activity,
        private string $taxSystem,
        private AbstractActivityStrategy $strategy,
        private ?int $id = null,
    ){}

    public function buildReport(float $caHt): string
    {
        $activityLabels = ["bic-vente" => "BIC Vente", "bic" => "BIC", "bnc" => "BNC"];
        $taxLabels = ["ps" => "Prélévement à la source", "vfl" => "Versement fiscal libératoire"];
        $header = $this->fullName . " " . $activityLabels[$this->activity] . " " . $taxLabels[$this->taxSystem] . PHP_EOL;
        return $header . $this->strategy->buildReport($caHt, $this->taxSystem);
    }

    public function describe(): string
    {
        return $this->id . " " . $this->fullName . " " . $this->siret . " " . $this->activity . " " . $this->taxSystem;
    }
}