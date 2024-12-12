# GUIDE D'INSTALLATION DE GESTION_JEUX #

* Importer le script de création des tables dans votre base de données
* Importer le script d'insertion dans votre base de données
* A la racine du projet (dossier `pj_gestion_jeux`), ouvrir le terminal
* Ecrire `composer install` pour installer les dépendances de PHP
* Ecrire `npm install` puis `npm run build` pour installer les paquets de Node.js
* Renommer le fichier `.env.example` en `.env` (afficher les fichiers cachés si il n'est pas visibile)
* Dans le fichier `.env`, aller à cette section  :
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_TABLE_PREFIX=
```
* Remplir ces lignes avec les informations de votre base de données ainsi que le préfixe de vos tables
* Pour démarrer le projet, écrire `php artisan serve` dans le terminal