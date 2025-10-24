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


---

# Démonstration 2

## Accès aux Services

- Site Web Vulnérable **CSRF** : http://localhost:5000/login
    - Se connecter avec un utilisateur (ex: alice / password123)
- Site Attaquant : http://localhost:808

> **Attention:** Pour fonctionner, la faille CSRF nécessite que l'utilisateur soit connecté sur le site vulnérable, et qu'il visite le site attaquant.
> Et ce, sur le même navigateur.

## Scénario de Test

1. Se connecter sur le site vulnérable
2. Ouvrir le **site attaquant dans un nouvel onglet**
3. Observer le changement de mot de passe sans consentement
> Le script malveillant envoie une requête pour changer le mot de passe de alice en hacked123.
4. Vérifier le changement de mot de passe
    - Déconnectez-vous du site vulnérable
    - Tentez de vous reconnecter avec le nouveau mot de passe : hacked123

> Le mot de passe de alice a été changé sans son consentement !


## Explication de la faille

- Le site vulnérable ne vérifie pas l’**origine** des requêtes (Origin/Referer).
- Le site malveillant exploite la session authentifiée de l’utilisateur pour envoyer une requête forgée = CSRF.

## Solution pour se protéger

Pour corriger la faille, ajoutez un token CSRF à l’application vulnérable :

Utilisez le module flask_wtf.csrf ou générez un token manuellement.
Vérifiez ce token à chaque requête sensible.

Exemple de correction avec Flask-WTF :
python Copierfrom flask_wtf.csrf import CSRFProtect

app = Flask(__name__)
app.config["SECRET_KEY"] = "votre_cle_secrete"
csrf = CSRFProtect(app)
Et ajoutez le token dans le formulaire :
html Copier<input type="hidden" name="csrf_token" value="{{ csrf_token() }}">


## Questions pour les étudiants

- Pourquoi cette attaque fonctionne-t-elle ?
- Comment le token CSRF empêche-t-il cette attaque ?
- Quelles autres mesures peuvent être mises en place pour se protéger ?
