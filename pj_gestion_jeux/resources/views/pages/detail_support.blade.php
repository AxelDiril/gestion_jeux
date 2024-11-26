@extends('layouts/structure')

@section('titre')
    {{ $iSupportId != null && isset($objSupport) ? $objSupport->support_name : 'Erreur' }}
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    @if($iSupportId == null || isset($objSupport) == false)
        <p>Aucun support n'a été sélectionné</p>
    @else
        <h1>{{ $objSupport->support_name }}</h1>

        <p>Date de sortie : {{ $objSupport->support_year}}</p>
        <p>Description : {{ $objSupport->support_desc }}</p>
    @endif
    <a href="/liste_supports">Retour à la liste des supports</a>
@stop

