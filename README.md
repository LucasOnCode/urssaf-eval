## Évaluation PHP Orienté Objet (24h)

<hr>

SPE 2 : POO CDA

Live Campus

2026

Paul Schuhmacher

Version: 1

<hr>

Instructions à copier coller dans le terminal pour tester :

composer install

php urssafc.php add "John Incubator Jones" 18812369758410 bic-vente ps

php urssafc.php add "Emily Brontë" 33512369768412 bic vfl

php urssafc.php ls

php urssafc.php dry-declare 1 3235

php urssafc.php dry-declare 2 4050

## Questions (5 points)

**Répondez** de manière *succincte* aux questions suivantes :

> Ces questions sont avant tout là pour vous faire prendre du recul sur le design que vous avez mis en place et ses avantages

1. En quoi votre système respecte [l'*Open Close Principle*](https://en.wikipedia.org/wiki/Open%E2%80%93closed_principle) (ouvert à l'extension, fermé à la modification) ?

Mon système respecte parce que je crée juste une nouvelle classe qui herite de AbstractActivity sans toucher aux classes déjà existantes et au script.

2. *Pourquoi* utilisons-nous un *design pattern* (*Stratégie*) ici ? **Justifier** d'après les spécifications et le contexte métier.

L'énoncé nous dit que les régimes, taux.. vont changer et comme c'est toujours le calcul avec cotisations et impots mais fait différement, le "strategy" permet de changer sans casser le reste. 

3. Pourquoi est-il important que votre *Domain* ou *Model* (le code métier, contenu du dossier `src`) reste indépendant ? Serait-il facilement réutilisable pour développer une version web de l'application ?

Le code métier ne dépend pas de comment les données sont stockées, ni de comment on les affiche.

4. **Réaliser** un **diagramme de classes UML** du système. Le script CLI apparaîtra sous la classe `Client`. **Indiquer** avec un schéma de couleur les classes/interfaces participantes au pattern *Strategy*. On ne fera apparaître que les classes/interfaces participantes avec leurs noms et leurs associations (pas les méthodes, ni les attributs). Pour cela, **utiliser votre logiciel favori** ([Diagrams(web)](https://app.diagrams.net/), [Umlet](https://www.umlet.com/), à la main, etc.). **Publier** le diagramme sur le dépôt.
