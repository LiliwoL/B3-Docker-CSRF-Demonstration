# Laboratoire de Démonstration CSRF - Protection

![](readme_docs/859089c8.png)


---

# Démonstration 1

## Accès aux Services

- Site Web Vulnérable CSRF : http://localhost:8080
- Site Attaquant : http://localhost:8081

## Modifications principales de sécurité

- Génération d'un token CSRF unique
- Validation systématique du token
- Utilisation de POST au lieu de GET
- Filtrage et validation des entrées
- Assainissement des données
- Utilisation de hash_equals() pour comparer les tokens
- Journalisation sécurisée avec verrouillage de fichier

---

## Journalisation Sécurisée

La ligne `file_put_contents('transfers.log', $logEntry, FILE_APPEND | LOCK_EX);` combine deux drapeaux importants :

**FILE_APPEND** (Ajout de contenu)

- Ajoute le contenu à la fin du fichier sans écraser le contenu existant
- Permet de conserver un historique complet des transactions

**LOCK_EX** (Verrouillage exclusif)

- Empêche plusieurs processus d'écrire simultanément dans le fichier
- Prévient les conditions de course (race conditions)
- Garantit l'intégrité du fichier de log en cas d'écritures parallèles

### Exemple de scénario sans verrouillage :

- Deux transferts simultanés
- Risque de données corrompues ou partiellement écrites
- Possibilité de perte d'informations

> Avec LOCK_EX, ces risques sont éliminés. Le système attend qu'une écriture soit terminée avant d'en autoriser une autre.