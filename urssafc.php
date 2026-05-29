<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Urssaf\ContractorRepository;

// 1. Configuration PDO SQLite...
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
$pdo = new PDO('sqlite:' . __DIR__ . '/urssafc.sq3', options: $options);
// 2. Création automatique de la table si elle n'existe pas...
$pdo->exec(file_get_contents(__DIR__ . "/schema.sql"));
$repository = new ContractorRepository($pdo);
$command = $argv[1] ?? null;

switch ($command) {
    case 'add':
        $fullName = $argv[2] ?? null;
        $siret = $argv[3] ?? null;
        $activity = $argv[4] ?? null;
        $taxSystem = $argv[5] ?? null;

        if (!$fullName || !$siret || !$activity || !$taxSystem) {
            echo "Erreur: Arguments manquants pour 'add'.\n";
            exit(1);
        }
        // 1. Valider le SIRET, gérer les doublons, et insérer en BDD
        if (!preg_match('/^\d{14}$/', $siret)) {
            echo "Erreur: SIRET invalide.\n";
            exit(1);
        }
        $repository->save($fullName, $siret, $activity, $taxSystem);
        echo "Auto-entreprise enregistrée.\n";
        break;

    case 'ls':
        // 1. Lister les microentreprises
        $contractors = $repository->findAll();
        foreach ($contractors as $c) {
            echo $c->describe() . PHP_EOL;
        }
        echo "Total: " . count($contractors) . PHP_EOL;
        break;

    case 'dry-declare':
        $id = isset($argv[2]) ? (int)$argv[2] : null;
        $caHt = isset($argv[3]) ? (float)$argv[3] : null;

        if (!$id || !$caHt) {
            echo "Erreur: Arguments manquants pour 'dry-declare'.\n";
            exit(1);
        }
        //1. Récupérer les données de l'auto-entreprise
        $contractor = $repository->find($id);
        if ($contractor === null) {
            echo "Autoentreprise introuvable\n";
            exit(1);
        }
        //2. Injecter la Strategy a un objet Contractor (autoentreprise) 
        //3. Calculer les cotisations sociales, appliquer la fiscalité et construire le rapport

        //Imprimer le rapport
        echo $contractor->buildReport($caHt);
        break;

    //Par convention, lancer une commande sans argument affiche le manuel
    default:
        echo "Usage:\n";
        echo "  php urssafc.php add \"NOM_COMPLET\" SIRET REGIME_ACTIVITE REGIME_FISCAL\n";
        echo "  php urssafc.php ls\n";
        echo "  php urssafc.php dry-declare ID CA_HT\n";
        exit(1);
}
