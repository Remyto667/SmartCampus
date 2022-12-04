Projet Smart Campus - SAE 2022
===================================
##########################################################################################
## Description
Un site web reliée à ades capteurs de C02, de température et d'humidité. Sur laquelle les utilisateurs pourront consulter les données
et recevoir les indications de ce qu'il faut faire selon ces données.
Les superviseurs eux pourront gérer les salles et les capteurs et suivre l'évolution et les comportements depuis l'application
Le but étant de réduire la consommation de l'université pour réduire l'impacte carbone et améliorer le confort

##########################################################################################
## 1.Démarrer le projet.


 1) Lancer docker,
 2) git clone https://forge.iut-larochelle.fr/SAE34-BUT-2022/x1/eq1/stack-sae-2022
 3) cd stack-sae-2022
 4) docker compose up --build -d
 5) docker exec -it sae-php bash (ou lancer le terminal sur docker)
 6) composer update
 7) http://localhost:9979 🎉
 8) bin/console doctrine:migrations:migrate
 9) bin/console doctrine:fixtures:load

Enlever son mot de passe de la salle D204 : git config --global --unset core.excludesfile
Push dans sa branche : git push -u origin nom_branche

créer branche : git checkout -b 

## 2. Utiliser la base de données

**Pour utiliser la base de données depuis le conteneur php :**  
_Adresse du serveur_ : `bdd` (c'est le nom du service dans le fichier `docker-compose.yml`)  
_Port_ : 3306 (le port MySQL par défaut)

**Pour utiliser la bdd avec un client MySQL _hors docker_** (par exemple celui de PHPStorm) :  
_Adresse du serveur_ : `localhost`  
_Port_ : 9978 (c'est lui)

Mot de passe root : `sae`.  
Par ailleurs, un utilisateur "standard" nommé `sae` a les droits d'accès sur une base de données nommée `sae`
avec le mot de passe `sae`

## 3. Wiki d'unification de devellopement

## **Le superviseur**

## Le code

les dossiers sont en anglais

les variables sont en anglais
## Le gitlab

les branches sont en anglais et décrit la fonction développé dedans

les commits sont faits dans n'importe quelles langues tant qu'il peut se faire comprendre par tout le monde et tout le temps

## Le Kanban


les us sont en français et décrit en français


## **L'utilisateur**


Tout ce que vois l'utilisateur sont en français comme les menus, les tableaux ou les routes