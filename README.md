Projet Smart Campus - SAE 2022
===================================
##########################################################################################
## Description
Un site web reliée à ades capteurs de C02, de température et d'humidité. Sur laquelle les utilisateurs pourront consulter les données
et recevoir les indications de ce qu'il faut faire selon ces données.
Les superviseurs eux pourront gérer les salles et les capteurs et suivre l'évolution et les comportements depuis l'application
Le but étant de réduire la consommation de l'université pour réduire l'impacte carbone et améliorer le confort

##########################################################################################

#### [Clique pour aller au Miro](https://miro.com/app/board/uXjVPQLLuuA=/)

##########################################################################################
## 1.Démarrer le projet.


 1) Lancer docker,
 2) git clone https://forge.iut-larochelle.fr/SAE34-BUT-2022/x1/eq1/stack-sae-2022
 3) cd stack-sae-2022
 4) docker compose up --build -d
 5) docker exec -it sae-php bash
 6) composer update
 7) http://localhost:9979 🎉
 9) bin/console doctrine:migrations:migrate
 10) bin/console doctrine:fixtures:load

Enlever son mot de passe de la salle D204 : git config --global --unset core.excludesfile
Push dans sa branche : git push -u origin nom_branche

Enlever son cable à partir du docker compose update D204

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

### **Le développeurr**

### Le code

les dossiers sont en anglais

les variables sont en anglais
### Le gitlab

les branches sont en anglais et décrit la fonction développé dedans

les commits sont faits dans n'importe quelles langues tant qu'il peut se faire comprendre par tout le monde et tout le temps

### Le Kanban


les us sont en français et décrit en français


### **Les utilisateurs (superviseurs, techniciens)**


Tout ce que vois l'utilisateur sont en français comme les menus, les tableaux ou les routes

## 4. Définition of READY

Avant de commencer à dev il faut que l'issue soit READY
Quand je créer une issue :

  * je me demande si c'est une tache ou une issue
  * je me demande si c'est une seule issue ou plusieurs
    * pour ça je peux me demander si a concerne 1 route, si ça peut être diviser, si ça peut être fait par plusieurs personnes, si c'est répétitif...
  * je trouve le nom de l'issue : verbe d'action + fonctionnalité + persona concerné
  * je specifie l'us avec "en tant que" + "je veux" + "afin de"
  * je défini les règles métier (ex : pour les conseils -> écrire pour chaque alertes quels conseils)
  * j'ajoute une maquette si c'est nécessaire
  * je défini les taches et je les spécifies pour que ça soit compréhensible par tous
  * je relis mon issue en me mettant à la place de quelqu'un qui n'est pas dans l'équipe : "est-ce qu'il comprendrais est ce qu'il saurait à quoi ça va ressembler"
  * je la met en READY

## 5. Définition of DONE

Quand je pense avoir fini le dev d'une issue je regarde si elle est DONE

  * je regarde si toutes les taches de l'issu ont été faites
  * est ce que toutes les règles métier sont respéctées
  * Est-ce que la fonctionnalité voulu par le client est opérationnel (je vérifie le "en tant que" + "je veux" + "afin de")
  * je la met en à tester, elle ne sera fini qu'après la fin du sprint