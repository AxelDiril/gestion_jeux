@extends('layouts/structure')

@section('titre')
    {{ $objGame->game_name }}
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    @if($iGameId == null)
        <p>Aucun jeu n'a été sélectionné</p>
    @else
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
        <p>Moyenne : {{$objGame->rating}}</p>
        <p>Description : {{ $objGame->game_desc }}</p>
    @endif
@stop

