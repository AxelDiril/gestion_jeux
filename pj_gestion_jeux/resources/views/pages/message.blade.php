@extends('layouts/structure')

@section('titre')
    Ajout à la collection
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    {{ $strMessage }}
    <a href="{{ $strLink }}">{{ $strLinkMessage }}</a>
@stop

