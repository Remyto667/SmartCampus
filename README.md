Stack de développement PHP SAE 2022
===================================
##########################################################################################

### 5. Que faire pour démarrer le projet.
-----------------------------

 1) Lancer docker,
 2) git clone https://forge.iut-larochelle.fr/SAE34-BUT-2022/x1/eq1/stack-sae-2022
 3) cd stack-sae-2022 ----> cd build
 4) docker compose up --build -d
 5) docker exec -it sae-php bash 
 6) dans le bash ---> composer update
 7) http://localhost:9979 🎉
 8) bin/console doctrine:migrations:migrate (dans le bash symphony)
 9) bin/console doctrine:fixtures:load


Push dans sa branche : git push -u origin nom_branche

créer branche : git checkout -b 

### 6. Utiliser la base de données
-----------------------------

**Pour utiliser la base de données depuis le conteneur php :**  
_Adresse du serveur_ : `bdd` (c'est le nom du service dans le fichier `docker-compose.yml`)  
_Port_ : 3306 (le port MySQL par défaut)

**Pour utiliser la bdd avec un client MySQL _hors docker_** (par exemple celui de PHPStorm) :  
_Adresse du serveur_ : `localhost`  
_Port_ : 9978 (c'est lui)

Mot de passe root : `sae`.  
Par ailleurs, un utilisateur "standard" nommé `sae` a les droits d'accès sur une base de données nommée `sae`
avec le mot de passe `sae`

Le serveur web
--------------

Les fichiers du répertoire `/symfony/public` sont servis par NginX sur le port 9979 (par le conteneur sae-web)

Composition de la stack
-----------------------

La stack comporte 3 conteneurs :
- PHP (8.1.10)
- NginX (1.20.1)
- MariaDB (10.9.2)
