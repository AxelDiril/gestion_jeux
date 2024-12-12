@extends('layouts/structure')

@section('titre')
    {{ $objGame->game_name }}
@stop

@section('contenu')
    <h1>{{ $objGame->game_name }}</h1>

    <p>Support : {{ $objGame->support->support_name }}</p>
    <p>Date de sortie : {{ $objGame->game_year}}</p>
    <p>Possédé par :
        @if(($objGame->owned_by) > 0)
            {{ $objGame->owned_by }} utilisateur(s)
        @else
            Personne
        @endif
    </p>
    @if ($objGame->rating)
        <p>Moyenne : {{$objGame->rating}} / 10</p>
    @else
        <p>Moyenne : Aucune note attribuée</p>
    @endif
    <p>Description : {{ $objGame->game_desc }}</p>
    <!-- Change le lien si l'utilisateur connecté possède déjà le jeu ou non -->
    @auth
        @if($bOwned == true)
            <a href="/delete_collection_jeu/{{ $objGame->game_id }}">Retirer de la collection</a>
        @else
            <a href="/ajout_jeu/{{ $objGame->game_id }}">Ajouter à la collection</a>
        @endif
    @endif
    <a href="/liste_jeux">Retour à la liste des jeux</a>
@stop

