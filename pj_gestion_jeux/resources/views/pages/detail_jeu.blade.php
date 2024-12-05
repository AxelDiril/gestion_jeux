@extends('layouts/structure')

@section('titre')
    {{ $objGame->game_name }}
@stop

@section('contenu')
    <p>Aucun jeu n'a été sélectionné</p>

    <h1>{{ $objGame->game_name }}</h1>

    <p>Support : {{ $objGame->support->support_name }}</p>
    <p>Date de sortie : {{ $objGame->game_year}}</p>
    <p>Possédé par :
        @if(($objGame->owned_by) > 0)
            {{ $objGame->owned_by }} utilisateurs
        @else
            Personne
        @endif
    </p>
    <p>Moyenne : {{$objGame->rating}} / 10</p>
    <p>Description : {{ $objGame->game_desc }}</p>
    @if (auth()->check())
        <a href="/ajout_jeu/game_id={{ $objGame->game_id }}">Ajouter à la collection</a>
    @endif
    <a href="/liste_jeux">Retour à la liste des jeux</a>
@stop

