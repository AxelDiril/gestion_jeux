# NOTES DE LARAVEL

# Sommaire

- [Reconstruire un projet Laravel cloné depuis GitHub](#reconstruire-un-projet-laravel-cloné-depuis-github)
- [Créer une nouvelle page](#créer-une-nouvelle-page)
- [Créer une nouvelle page avec un appel à la base de données](#créer-une-nouvelle-page-avec-un-appel-à-la-base-de-données)
- [Appel à la base de données avec une condition "WHERE"](#appel-à-la-base-de-données-avec-une-condition-where)
- [Importer des blocs de code dans un fichier](#importer-des-blocs-de-code-dans-un-fichier)
  - [Pour une partie du contenu](#pour-une-partie-du-contenu)
  - [Pour tout le code d'un fichier](#pour-tout-le-code-dun-fichier)
  - [Pour importer un fichier de Template (Layout)](#pour-importer-un-fichier-de-template-layout)
- [Récupérer un paramètre GET passé en lien](#récupérer-un-paramètre-get-passé-en-lien)

---

## Reconstruire un projet Laravel cloné depuis GitHub

* Remettre le `.env`` / en compléter un nouveau
* Reconstruire le fichier Vendor avec `composer install` dans un terminal à la racine du dossier

## Créer une nouvelle page

* Aller dans `/routes/web.php`.
* Créer une route en faisant :
```
Route::get('Namedelavue', function () {
    return view('Namedelavue');
});
```

## Créer une nouvelle page avec un appel à la base de données

* Aller dans `/routes/web.php`.
* Créer une route en faisant :
```
Route::get('/resource/Namedelavue', [NameDuControlleur::class, 'methodeAExecuterDansLeControlleur']);
```
* Dans le controlleur, ajouter en début de fichier le modèle à utiliser :
```
use app/Models/NameModele
```

* Ajouter une méthode avec le Name précisé dans la route :
```
public function liste_jeux(){        
    $listeEnregistrements = NameModele::all();
    return view('Namedelavue', compact('listeEnregistrements'));
}
```
* Dans la vue, manipuler la liste des enregistrements avec la variable `$listeEnregistrements`. Peut être utilisée avec un `foreach` pour parcourir la liste.

## Appel à la base de données avec une condition "WHERE"

* À la déclaration de la liste des enregistrements dans le controlleur, remplacer `all()` par `where('Nameduchamp','valeuràvérifier')->get()`. Les `where()` peuvent être cumulés pour vérifier plusieurs conditions en même temps.

## Importer des blocs de code dans un fichier

### Pour une partie du contenu

* Dans le fichier du code à importer, créer un bloc :
```
@section('Namedelasection')
    //contenu de la section
@stop
```
* Dans un autre fichier où il faut importer le code, mettre :
```
@yield('Namedelasection') // Remettre le même Name de section
```

### Pour tout le code d'un fichier
* Dans un fichier où il faut importer tout le code d'un autre fichier, mettre :
```
@include('Namedufichier')
```

### Pour importer un fichier de Template (Layout)
* Dans les fichier où il faut importer tout le squelette d'une page, mettre :
```
@extends('Namedufichier')
```
* Utile pour créer une page par défaut et en changer seulement le contenu.

## Récupérer un paramètre GET passé en lien
* Dans le controlleur, rajouter dans les paramètres de la méthode principale `Request $request`.
* La classe `Request` renvoie un tableau de all les paramètres passés en lien de la page `("?id=" par exemple)`.
* Pour récupèrer la valeur d'un paramètre en particulier, faire :
```
$valeurDuParametre = $request->query('Nameduparametre');
```