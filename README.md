# Laboratoire de Démonstration CSRF

![](readme_docs/859089c8.png)


---

# Démonstration 1

## Objectifs Pédagogiques

- Comprendre le mécanisme CSRF
- Identifier les vulnérabilités de sécurité
- Mettre en place des protections (cf. branche **protection**)

## Configuration

1. Installer Docker et Docker Compose
2. Cloner ce répertoire
3. Lancer l'environnement :
   ```bash
   docker-compose up -d
   ```

## Accès aux Services

- Site Web Vulnérable **CSRF** : http://localhost:8080
- Site Attaquant : http://localhost:8081

## Scénario de Test

1. Connectez-vous sur le site web **vulnérable**, tel un utilisateur normal
   > Utilisateur : alice  
   > Mot de passe : password123
   > 
   > Ou
   > 
   > Utilisateur : bob  
   > Mot de passe : securepwdpwd

Vous avez accès à un formulaire de transfert d'argent
 

2. Ouvrez le site attaquant **dans un nouvel onglet**
> Vous pouvez y voir un formulaire de transfert d'argent
> 
> Ce site est **contrôlé par un attaquant**, et le lien vers ce site, a été envoyé à l'utilisateur imprudent.
> 
> La faille **CSRF** nécessite que l'utilisateur soit connecté sur le site vulnérable, et qu'il visite le site attaquant.


3. Observez le transfert automatique **sans consentement**
4. Vérifiez les transferts dans le fichier **transferts.log**
5. Mettez en place une protection CSRF sur le site web vulnérable



---

# Démonstration 2

## Objectifs Pédagogiques
- Comprendre le mécanisme CSRF avec les requêtes AJAX


## Configuration

1. Installer Docker et Docker Compose
2. Cloner ce répertoire
3. Lancer l'environnement :
   ```bash
   docker-compose up -d
   ```

## Accès aux Services

- Site Web Vulnérable **CSRF** : http://localhost:5000/login
  - Se connecter avec un utilisateur (ex: alice / password123)
- Site Attaquant : http://localhost:8080

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
  
Branche correction

## Questions pour les étudiants

- Pourquoi cette attaque fonctionne-t-elle ?
- Comment le token CSRF empêche-t-il cette attaque ?
- Quelles autres mesures peuvent être mises en place pour se protéger ?
