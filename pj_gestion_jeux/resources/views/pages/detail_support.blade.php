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
            {{ $objSupport->owned_by }} utilisateur(s)
        @else
            Personne
        @endif
    </p>
    <!-- Change le lien si l'utilisateur connecté possède déjà le jeu ou non -->
    @auth
        @if($bOwned == true)
            <a href="/delete_collection_jeu/{{ $objGame->game_id }}">Retirer de la collection</a>
        @else
            <a href="/ajout_jeu/{{ $objGame->game_id }}">Ajouter à la collection</a>
        @endif
    @endif
    <a href="/liste_supports">Retour à la liste des supports</a>
@stop

