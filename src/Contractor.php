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
        $activityLabels
        $taxLabels
        $header
    }

    public function describe(): string
    {
        return $this->id . " " . $this->fullName . " " . $this->siret . " " . $this->activity . " " . $this->taxSystem;
    }
}
