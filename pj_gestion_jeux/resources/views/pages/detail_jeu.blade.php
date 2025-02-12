@extends('layouts/structure')

@section('titre')
    {{ $objGame->game_name }}
@stop

@section('contenu')
    <h1>{{ $objGame->game_name }}</h1>

    <p><b>Support :</b> {{ $objGame->support->support_name }}</p>
    <p><b>Date de sortie :</b> {{ $objGame->game_year}}</p>
    <p><b>Possédé par :</b>
        @if(($objGame->owned_by) > 0)
            {{ $objGame->owned_by }} utilisateur(s)
        @else
            Personne
        @endif
    </p>
    @if ($objGame->rating)
        <p><b>Moyenne :</b> {{$objGame->rating}} / 10</p>
    @else
        <p><b>Moyenne :</b> Aucune note attribuée</p>
    @endif
    <p><b>Description :</b> {{ $objGame->game_desc }}</p>
    <!-- Change le lien si l'utilisateur connecté possède déjà le jeu ou non -->
    @auth
        @if($bOwned == true)
            <a href="/delete_collection_jeu/{{ $objGame->game_id }}" class="btn btn-info">Retirer de la collection</a>
        @else
            <a href="/ajout_jeu/{{ $objGame->game_id }}" class="btn btn-info">Ajouter à la collection</a>
        @endif
    @endif
    <a href="/liste_jeux" class="btn btn-info">Retour à la liste des jeux</a>
@stop

