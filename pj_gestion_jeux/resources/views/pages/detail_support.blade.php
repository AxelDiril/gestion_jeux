@extends('layouts/structure')

@section('titre')
    {{ $objSupport->support_name }}
@stop

@section('contenu')

    <h1>{{ $objSupport->support_name }}</h1>

    <p>Date de sortie : {{ $objSupport->support_year}}</p>
    <p>Description : {{ $objSupport->support_desc }}</p>
    <p>Possédé par :
        @if(($objSupport->owned_by) > 0)
            {{ $objSupport->owned_by }} utilisateurs
        @else
            Personne
        @endif
    </p>
    @if (auth()->check())
        <a href="/ajout_support?support_id={{ $objSupport->support_id }}">Ajouter à la collection</a>
    @endif
    <a href="/liste_supports">Retour à la liste des supports</a>
@stop

