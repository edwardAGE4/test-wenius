# test-wenius

## Test d’aptitudes Développeur Informatique Wenius

=================================================================

### Technologies

* Symfony 2 (PHP)
* MySQL
* HTML + CSS + JS
* Twitter Bootstrap

=================================================================

### Pré-requis

* PHP 5.3.3 au moins (Ne fonctionne pas bien sur PHP 5.3.16)
* Configuration de php
    * `date.timezone` doit être défini ('Europe/Paris' par exemple)
    * `mod_rewrite` doit être activé et `AllowOverride` doit être à `All` dans la configuration du `VirtualHost` (Pas obligatoire)
* [Composer](https://getcomposer.org/download/)
* [Bower](https://bower.io/)
    * Peut nécessiter [npm](https://www.npmjs.com/get-npm)
* [Droits du service apache2 sur les répertoires de cache et de logs](http://symfony.com/doc/current/setup/file_permissions.html)  

=================================================================

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