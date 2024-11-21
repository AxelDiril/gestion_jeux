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
Route::get('nomdelavue', function () {
    return view('nomdelavue');
});
```

## Créer une nouvelle page avec un appel à la base de données

* Aller dans `/routes/web.php`.
* Créer une route en faisant :
```
Route::get('/resource/nomdelavue', [NomDuControlleur::class, 'methodeAExecuterDansLeControlleur']);
```
* Dans le controlleur, ajouter une méthode avec le nom précisé dans la route :
```
public function liste_jeux(Request $request){        
    $listeEnregistrements = NomModele::all();
    return view('nomdelavue', compact('listeEnregistrements'));
}
```
* Dans la vue, manipuler la liste des enregistrements avec la variable `$listeEnregistrements`. Peut être utilisée avec un `foreach` pour parcourir la liste.

## Appel à la base de données avec une condition "WHERE"

* À la déclaration de la liste des enregistrements dans le controlleur, remplacer `all()` par `where('nomduchamp','valeuràvérifier')->get()`. Les `where()` peuvent être cumulés pour vérifier plusieurs conditions en même temps.

## Importer des blocs de code dans un fichier

### Pour une partie du contenu

* Dans le fichier du code à importer, créer un bloc :
```
@section('nomdelasection')
    //contenu de la section
@stop
```
* Dans un autre fichier où il faut importer le code, mettre :
```
@yield('nomdelasection') // Remettre le même nom de section
```

### Pour tout le code d'un fichier
* Dans un fichier où il faut importer tout le code d'un autre fichier, mettre :
```
@include('nomdufichier')
```

### Pour importer un fichier de Template (Layout)
* Dans les fichier où il faut importer tout le squelette d'une page, mettre :
```
@extends('nomdufichier')
```
* Utile pour créer une page par défaut et en changer seulement le contenu.

## Récupérer un paramètre GET passé en lien
* Dans le controlleur rajouter dans les paramètres de la méthode principale `Request $request`.
* La classe `Request` renvoie un tableau de toutes les paramètres passés en lien de la page `("?id=" par exemple)`.
* Pour récupèrer la valeur d'un paramètre en particulier, faire :
```
$valeurDuParametre = $request->query('nomduparametre');
```