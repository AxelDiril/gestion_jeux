# Documentation technique de Gestion Jeux

## Introduction

## Arborescence

> **pj_gestion_jeux**
> * **app/**  
>     * **Controllers/**  
>         * *Définition des contrôleurs du projet*  
>     * **Models/**  
>         * *Définition des modèles*  
> * **public/**  
>     * **styles/**  
>         * *Les fichiers CSS utilisés*  
> * **resources/**  
>     * **views/**  
>         * **auth/**  
>             * *Pages pour l'authentification avec Breeze*  
>         * **includes/**  
>             * *Parties de vues à afficher*  
>         * **layouts/**  
>             * `structure.layout.blade.php` *(Structure principale des vues)*  
>         * **pages/**  
>             * *Contenu des pages à afficher*  
> * **routes/**  
>     * `web.php` *(Définition de toutes les routes du projet)*  


## Structure de la base de données                                                   |

### Table `GJ_collection_games`

| Champ         | Type            | Description                                                                                                               |
|---------------|-----------------|---------------------------------------------------------------------------------------------------------------------------|
| `game_id`     | `INT(11)`       | Identifiant unique du jeu faisant référence à la clé primaire de `GJ_games`.                                                                                                 |
| `id`          | `INT(11)`       | Identifiant unique de l'utilisateur faisant référence à la clé primaire de `GJ_users`.                                                              |
| `note`        | `FLOAT`         | Note du jeu donnée par l'utilisateur.                                                                                      |
| `comment` | `VARCHAR(300)`          | Commentaire de l'utilisateur sur le jeu.                                                                                   |
| `progress_id` | `INT(11)`       | Identifiant du statut de progression du jeu faisant référence à la clé primaire de `GJ_progressions`.                                               |
| `added_at`    | `DATETIME`      | Date et heure d'ajout du jeu à la collection de l'utilisateur.                                                            |

---

### Table `GJ_collection_supports`

| Champ        | Type            | Description                                                                                                               |
|--------------|-----------------|---------------------------------------------------------------------------------------------------------------------------|
| `support_id` | `INT(11)`       | Identifiant unique du support de jeu faisant référence à la clé primaire de `GJ_supports`.                                                        |
| `id`         | `INT(11)`       | Identifiant unique de l'utilisateur faisant référence à la clé primaire de `GJ_users`.                                                            |
| `comment`| `VARCHAR(300)`          | Commentaire de l'utilisateur concernant le support.                                                  |
| `added_at`   | `DATETIME`      | Date et heure d'ajout du support de jeu à la collection de l'utilisateur.                                                  |

---

### Table `GJ_games`

| Champ         | Type            | Description                                                                                                               |
|---------------|-----------------|---------------------------------------------------------------------------------------------------------------------------|
| `game_id`     | `INT(11)`       | Identifiant unique du jeu.                                                                                                 |
| `game_name`   | `VARCHAR(255)`   | Nom du jeu.                                                                                                               |
| `game_desc`   | `VARCHAR(500)`          | Description du jeu.                                                                                                        |
| `game_year`   | `YEAR(4)`       | Année de sortie du jeu.                                                                                                   |
| `game_cover`  | `VARCHAR(255)`   | Nom du fichier de la jaquette du jeu.                                                                           |
| `owned_by`    | `INT(11)`       | Nombre d'utilisateurs possèdant le jeu. Mis à jour avec les Triggers `TGR_delete_game` et `TGR_update_game`.                                                                           |
| `rating`      | `FLOAT`         | Moyenne des notes des utilisateurs pour le jeu. Mis à jour avec le Trigger `TGR_update_game`.                                                    |
| `support_id`  | `INT(11)`       | Identifiant unique du support de jeu sur lequel le jeu est sorti faisant référence à la clé primaire de `GJ_supports`.                                                                       |

---

### Table `GJ_game_genres`

| Champ        | Type            | Description                                                                                                               |
|--------------|-----------------|---------------------------------------------------------------------------------------------------------------------------|
| `game_id`    | `INT(11)`       | Identifiant du jeu faisant référence à la clé primaire de `GJ_games`.                                                                            |
| `genre_id`   | `INT(11)`       | Identifiant du genre du jeu faisant référence à la clé primaire de `GJ_genres`.                                                                  |

---

### Table `GJ_genres`

| Champ        | Type            | Description                                                                                                               |
|--------------|-----------------|---------------------------------------------------------------------------------------------------------------------------|
| `genre_id`   | `INT(11)`       | Identifiant unique du genre.                                                                                               |
| `genre_label`| `VARCHAR(255)`   | Libellé du genre de jeu (Action, Aventure, etc.).                                                                            |

### Table `GJ_progressions`

| Champ            | Type        | Description                                                                                             |
|------------------|-------------|---------------------------------------------------------------------------------------------------------|
| `progress_id`    | `INT(11)`   | Identifiant unique de la progression.                                                                   |
| `progress_label` | `VARCHAR(30)` | Libellé de la progression. Représente l'avancée de l'utilisateur dans un jeu qu'il possède. |

---

### Table `GJ_requests`

| Champ            | Type        | Description                                                                                             |
|------------------|-------------|---------------------------------------------------------------------------------------------------------|
| `request_id`     | `INT(11)`   | Identifiant unique de la demande.                                                                        |
| `request_motif`  | `VARCHAR(300)` | Motif en cas de refus de la demande.                                                                          |
| `request_nom`    | `VARCHAR(70)`  | Nom du jeu de la demande.                                                                                      |
| `request_desc`   | `VARCHAR(500)` | Description du jeu de la demande.                                                                    |
| `request_year`   | `YEAR(4)`   | Année de sortie du jeu de la demande.                                                                             |
| `request_cover`  | `VARCHAR(300)` | Nom de fichier du jeu de la demande.                                                  |
| `id`             | `BIGINT(20) UNSIGNED` | Identifiant de l'utilisateur ayant fait la demande faisant référence à la clé primaire de `GJ_users`.                                          |
| `status_id`      | `INT(11)`   | Identifiant de l'état actuel de la demande faisant référence à la clé primaire de `GJ_status`.                                    |
| `valide_id`      | `BIGINT(20) UNSIGNED` | Identifiant de l'utilisateur ayant le rôle "Validateur" qui a traîté la demande d'ajout du jeu. Fait référence à la clé primaire de `GJ_users`. |

---

### Table `GJ_roles`

| Champ            | Type        | Description                                                                                             |
|------------------|-------------|---------------------------------------------------------------------------------------------------------|
| `role_code`      | `CHAR(1)`   | Code unique représentant un rôle.   |
| `role_label`     | `VARCHAR(30)` | Libellé du rôle (Administrateur, Utilisateur...).                                    |

---

### Table `GJ_status`

| Champ            | Type        | Description                                                                                             |
|------------------|-------------|---------------------------------------------------------------------------------------------------------|
| `status_id`      | `INT(11)`   | Identifiant unique de l'état d'une demande.                                                                           |
| `status_label`   | `VARCHAR(30)` | Libellé de l'état d'une demande (En attente, Validé...).                                         |

---

### Table `GJ_supports`

| Champ            | Type        | Description                                                                                             |
|------------------|-------------|---------------------------------------------------------------------------------------------------------|
| `support_id`     | `INT(11)`   | Identifiant unique du support.                                                                          |
| `support_name`   | `VARCHAR(70)`  | Nom du support.                                                |
| `support_desc`   | `VARCHAR(300)` | Description du support.                                                                       |
| `support_year`   | `YEAR(4)`   | Année de sortie du support.                                                                          |
| `support_pic`    | `VARCHAR(200)` | Nom de fichier d'une image représentant le support.                                                  |
| `support_logo`   | `VARCHAR(200)` | Nom de fichier du logo du support.                                                                  |
| `owned_by`       | `INT(11)`   | Nombre de personnes possèdant le support. Mis à jour avec les Triggers `TGR_delete_support` et `TGR_insert_support`.     |

---

### Table `GJ_users`

| Champ               | Type            | Description                                                                                             |
|---------------------|-----------------|---------------------------------------------------------------------------------------------------------|
| `id`                | `BIGINT(20) UNSIGNED` | Identifiant unique de l'utilisateur.                                                                     |
| `name`              | `VARCHAR(255)`   | Nom de l'utilisateur.                                                                            |
| `email`             | `VARCHAR(255)`   | Adresse e-mail de l'utilisateur.                                                                         |
| `email_verified_at` | `TIMESTAMP`      | Date et heure de la vérification de l'email (null si non vérifié).                                       |
| `password`          | `VARCHAR(255)`   | Mot de passe hashé de l'utilisateur.                                             |
| `remember_token`    | `VARCHAR(100)`   | Token utilisé pour mémoriser la session de l'utilisateur lors de sa connexion.                          |
| `telephone`         | `VARCHAR(20)`    | Numéro de téléphone de l'utilisateur.                                                   |
| `visibilite`        | `TINYINT(1)`     | Détermine si le profil de l'utilisateur peut-être consulté publiquement ou non.                             |
| `can_contribute`    | `TINYINT(1)`     | Indique si l'utilisateur peut formuler des demandes d'ajout de jeux.                                      |
| `code`              | `CHAR(1)`        | Code représentant le rôle d'un utilisateur faisant référence à la clé primaire de `GJ_roles`.                    |
| `comment`           | `VARCHAR(250)`   | Commentaire facultatif pour les tests en base de données, notamment pour afficher les mots de passe.                                                       |
| `created_at`        | `TIMESTAMP`      | Date et heure de la création du compte utilisateur.                                                     |
| `updated_at`        | `TIMESTAMP`      | Date et heure de la dernière mise à jour du compte utilisateur.                                         |

## Routes

Toutes les routes utilisées par le projet sont définies dans `routes\web.php`. Chaque lien a une route associée qui appelle un contrôleur qui retourne la vue correspondante. Certaines routes ne peuvent être accédée qu'avec un paramètre comme `detail_jeu` car un identifiant de jeu est forcément nécessaire pour afficher les informations associées.

## Modèles

Les modèles ont été générés avec l'ORM **Eloquent** de Laravel pour qu'ils correspondent aux tables dans la base de données. Ils portent tous le nom de la table qui leur est associée.

## Contrôleurs

Des contrôleurs ont été créés pour chaque modèle utilisé dans l'application :
* **CollectionGameController** : sert à afficher, ajouter, supprimer et mettre à jours des jeux dans la collection d'un utilisateur.
* **CollectionSupportController** : sert à afficher, ajouter, supprimer et mettre à jours des supports dans la collection d'un utilisateur.
* **GameController** : sert à afficher la liste des jeux de `GJ_games` en appliquant des filtres de recherche optionnels ou le détail d'un jeu en particulier sur une page à part.
* **SupportController** : sert à afficher la liste des supports de `GJ_supports` en appliquant des filtres de recherche optionnels ou le détail d'un support en particulier sur une page à part.
* **UserController** : permet d'afficher un profil, la liste des membres ayant un profil public et de changer la visibilité d'un profil (public / privé) d'un utilisateur connecté. Pour les membres ayant le rôle "administrateur" ou "validateur", sert aussi à afficher une liste de tous les membres, mettre à jour leur rôles et droits et d'exclure un membre.

Lorsqu'une page nécessite un paramètre obligatoire, il est directement indiqué par son nom dans les paramètres des méthodes. Pour tous les paramètres optionnels comme les filtres de recherche, ils sont récupérés avec l'objet `Request` en paramètres. Sa valeur est récupérée avec la méthode `query()` :

```
public function methode(Request $request)
    {
        $valeurARecuperer = $request->query('nom_du_parametre');
    }
```

Chaque méthode des contrôleurs retourne une vue avec la méthode `view('chemin_vue')`. Des informations supplémentaires sont envoyées avec la fonction `compact('')` prenant en paramètres les variables déclarées juste avant.

## Gestion des vues

Chaque vue est générée dynamiquement avec le moteur Blade et a pour extension `blade.php` pour fonctionner. Chaque page est construite selon la structure de `layouts/structure.blade.php`. L'entête et le pied de page du dossier `includes` sont appelés avec la fonction `@include('nom_fichier)` et les parties de la vue qui changent selon la page comme le titre et le contenu sont appelées avec `@yield('nom_section')`.

Dans les fichiers de vues contenus dans `/pages`, la structure est appelée avec `@extends('layouts/structure')` et les parties dynamiques sont définies par des `@section('nom_section')`.

## Gestion des listes et des filtres

Chaque liste de Gestion Jeux est générée dynamiquement en récupérant un tableau de valeurs depuis le contrôleur. 

Dans le contrôleur, la requête de selection pour les jeux/supports/utilisateurs est construite avec le **Query Builder** de Laravel :
```
// Récupérer tous les utilisateurs
$arUsers = User::query();
...
$arUsers = $arUsers->get();
```

Pour appliquer les filtres récupérés en paramètres, des conditions sont ajoutées à la requête avec la méthode `where('champ',valeur)` :
```
if (!empty($strName)) {
            $arUsers->where('name', 'LIKE', '%' . $strName . '%');
}
```

Le tableau d'enregistrements est passé à la vue avec `compact('nom_tableau')`.

Dans les vues, une boucle `@foreach()` parcourt le tableau récupéré et génère une case/ligne pour chacun d'entre eux.

Les listes déroulantes des filtres sont générées de la même manière. Si un filtre a été sélectionné pour une recherche, une condition vérifie si l'enregistrement en cours d'ajout correspond à celui qui a été choisi pour qu'il soit sélectionné au chargement de la page :
```
// $iSupportId est l'ID du support sélectionné envoyé depuis le contrôleur

<option value="{{ $keySupport->support_id }}" 
        {{ $keySupport->support_id == $iSupportId ? 'selected' : '' }}
>
```

## Gestion des messages d'erreur / confirmation

Pour chaque action de l'utilisateur ou erreur trouvée, la vue `message.blade.php` est retournée dans les méthodes de contrôleurs. Elle est générée dynamiquement à partir de trois variables passées depuis le contrôleur :
* **strMessage** : Le message d'erreur ou de confirmation
* **strLink** : Un lien pour retourner sur une autre page
* **strLinkMessage** : Texte indiquant vers quelle page mène le lien

## Authentification et vérification des rôles

La connexion à Gestion Jeux est gérée avec le package Breeze de Laravel.

Les boutons *S'inscrire* et *Se connecter* de l'entête mènent vers les routes `register` et `login` créées par Breeze de `routes/auth.php`. Les vues retournées par les méthodes des contrôleurs `AuthenticatorSessionController` et `RegisteredUserController` de Breeze ont été modifiées pour retourner la vue `accueil` de **Gestion Jeux**.

L'application vérifie si l'utilisateur est connecté pour afficher la déconnexion dans l'entête, le lien d'ajout/suppression sur les pages de détail de jeu/support, le lien de changement de visibilité sur son profil et les options sur sa collection.

Dans les vues, la condition `@auth` vérifie si l'utilisateur est connecté :
```
@auth
// Bouton de déconnexion
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <input type="submit" value="Se déconnecter">
</form>
@else
// Lien de connexion / inscription
<a href="{{ route('login') }}">Se connecter</a>
<a href="{{ route('register') }}">S'inscrire</a>
@endif
```

Pour restreindre certaines fonctionnalités aux utilisateurs, un objet `Auth::user()` retourne les informations de l'utilisateur conencté pour vérifier son rôle dans la base de données :
```
$objUser = Auth::user();

// Restreindre les utilisateurs ayant le code "U"
// pour réserver une page au code "V" et "A"

if ($objUser == false || $objUser->code == "U") {
    return redirect('/');
}
```



