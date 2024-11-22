@extends('layouts/structure')

@section('titre')
    Détail
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>{{ $arGames->titre }}</h1>

