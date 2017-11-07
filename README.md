# test-wenius

## Test d’aptitudes Développeur Informatique Wenius

___

### Technologies

* Symfony 2 (PHP)
* MySQL
* HTML + CSS + JS
* Twitter Bootstrap

___

### Pré-requis

* PHP 5.6 au moins
* Configuration de PHP
    * `date.timezone` doit être défini ('Europe/Paris' par exemple)
* Configuration de Apache
    * `mod_rewrite` doit être activé et `AllowOverride` doit être à `All` dans la configuration du `VirtualHost` _(Pas obligatoire)_
* [Composer](https://getcomposer.org/download/)
* [Bower](https://bower.io/)
    * Peut nécessiter [npm](https://www.npmjs.com/get-npm)
* [Droits de l'utilisateur du service apache sur les répertoires de cache et de logs](http://symfony.com/doc/current/setup/file_permissions.html)   

___

### Déploiement et exécution

1. Vérifier les pré-requis
1. Créer une base de données MySQL vide pour le projet
1. Placer le projet dans le répertoire public du serveur apache
1. Ouvrir un terminal et se placer dans le répertoire du projet
1. Exécuter `./deploy.sh`
1. Remplir les informations demandées durant l'exécution du script à savoir :
    2. L'hôte du serveur MySQL
    2. Le port du serveur MySQL
    2. Le nom de la base de données créée précédemment
    2. Le nom d'utilisateur pour se connecter à la base de données
    2. Le mot de passe pour se connecter à la base de données
1. Lancer votre serveur apache
1. Ouvrir un navigateur vous rendre à l'accueil de l'application :
    2. Si `mod_rewrite` est activé et `AllowOverride` à `All` dans la configuration du `VirtualHost` de Apache
        * `{adresse du serveur}:{port du serveur}/{repertoire du projet}/web`
        * Exemple : `localhost:80/test-wenius/web`
    2. Sinon
        * `{adresse du serveur}:{port du serveur}/{repertoire du projet}/web/app.php`
        * Exemple : `localhost:80/test-wenius/web/app.php`

___

### A savoir

Pour que vous puissiez tester sans soucis, les routes de l'api REST n'ont pas été sécurisées.

Voici la liste des routes de l'api REST :
* `api/users` : La liste des utilisateurs
* `api/users/{id}` : Les détails de l'utilisateur {id}
* `api/cars` : La liste des véhicules
* `api/cars/{id}` : Les détails du véhicule {id}
* `api/cars/{id}/problems` : La liste des problèmes du véhicule {id}
* `api/problems/{id}` : Les détails du problème {id}
* `api/cars/{id}/operations` : La liste des opérations du véhicule {id}
* `api/operations/{id}` : Les détails de l'opération {id}
* `api/operations/{id}/interventions` : La liste des interventions de l'opération {id}
* `api/interventions/{id}` : Les détails de l'intervention {id}

___

### Difficultés rencontrées
* Création des deux types d'utilisateur via un même formulaire
* Récupération des données et statistiques pour le tableau de bord
* Réalisation de l'api REST car n'ayant jamais fait celà auparavant

### Intérêts
* Apprentissage de nouvelles choses
* Première réalisation d'une api REST
* Challenge imposé par le temps limite et les autres occupations

___

### Documentation du code

* Structure MVC (Model - View - Controller)

* Code source dans le répertoire `src`
    * Les routes ont été déninies au fur et à mesure en Annotations dans les fichiers controller
    * `AppBundle` contient le code source lié à l'application web
        * `Controller` contient les Controller
            * `Security` référence aux utilisateurs et au login
            * `Work` référence aux traitements métiers
        * `Entity` contient les classes Model
            * `Security` référence aux utilisateurs
            * `Work` référence aux traitements métiers
            * `Media` référence aux médias traités
        * `Repository` contient des dépôts où sont mises les requêtes sur les données de nos model
            * `Security` référence aux utilisateurs
            * `Work` référence aux traitements métiers
            * `Media` référence aux médias traités
        * `Resources/views` contient les fichiers de vue retournés par les controller
            * `Security` référence aux utilisateurs
            * `Work` référence aux traitements métiers
            * `Default` référence à l'accueil ou au tableau de bord
        * `Form` contient les formulaires types affichés dans les vues et traités dans les controller
            * `Security` référence aux utilisateurs
            * `Work` référence aux traitements métiers
            * `Media` référence aux médias traités
    * `ApiBundle` contient le code source lié à l'api
        * `Controller` contient les Controller
            * `Security` référence aux utilisateurs et au login
            * `Work` référence aux traitements métiers

* Assets (CSS et JS)
    * Dépendances récupérées via bower dans le répertoire `web/assets`
    * Personnalisations dans le répertoire `web/custom`

* Uploads dans le répertoire `web/uploads`