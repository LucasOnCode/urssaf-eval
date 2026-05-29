<?php

namespace Urssaf;

class ContractorRepository
{
    //Injection de dépendance dans le constructeur de l'instance PDO (accès a la base de données)
    public function __construct(private \PDO $pdo) {}


    /**
     * Retourne l'identifiant généré par la base pour le nouveau record
     * @throws \Exception Si l'insertion en base de données échoue
     * @return int
     */
    public function save(string $fullName, string $siret, string $activity, string $taxSystem): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO contractor (full_name, siret, activity, tax_system)
            VALUES (:fullName, :siret, :activity, :taxSystem)"
        );
        $stmt->execute([
            "fullName" => $fullName,
            "siret" => $siret,
            "activity" => $activity,
            "taxSystem" => $taxSystem,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function find(int $id): ?Contractor
    {
        $stmt = $this->pdo->prepare("SELECT * FROM contractor WHERE id = :id");
        $stmt->execute(["id"=>$id]);
        $row = $stmt->fetch();
        if (!$row) 
        {
            return null;
        }
        $strategy = match ($row["activity"]) {
            "bic" => new BicStrategy(),
            "bic-vente" => new BicVenteStrategy(),
            "bnc" => new BncStrategy(),
        };
        return new Contractor(
            $row["full_name"],
            $row["siret"],
            $row["activity"],
            $row["tax_system"],
            $strategy,
            (int)$row["id"],
        );
    }

    /**
     * @return array<Contractor>
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM contractor ORDER BY id");
        $contractors = [];
        foreach ($stmt as $row) {
            $strategy = match ($row["activity"]) {
                "bic" => new BicStrategy(),
                "bic-vente" => new BicVenteStrategy(),
                "bnc" => new BncStrategy(),
            };
            $contractors[] = new Contractor(
                $row["full_name"],
                $row["siret"],
                $row["activity"],
                $row["tax_system"],
                $strategy,
                (int)$row["id"],
            );
        }
        return $contractors;
    }
}
