@extends('layouts/structure')

@section('titre')
    Profil
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>Profil de {{ $objUser->name }}</h1>

    @auth
        <a href="/change_visibilite/{{ $objUser->id }}">Passer votre profil en : {{ $objUser->visibilite == 0 ? 'public' : 'privé' }}</a>
    @endif

    <p>Nombre de jeux possédés : {{$iTotalGames}}</p>

    <p>Nombre de supports possédés : {{$iTotalSupports}}</p>

    <h2>Derniers jeux de la collection</h2>

    <div class="game_grid">
        @foreach($arLatestGames as $keyGame)
        <div class="game_item">
                <a href="/detail_jeu/{{ $keyGame->game_id }}">{{ $keyGame->game->game_name }}</a>
                <p>{{ $keyGame->game->game_year }}</p>
                <p>{{ $keyGame->game->support->support_name }}</p>
        </div>
        @endforeach
    </div>

    <a href="/profil_collection_jeux/{{ $objUser->id }}">Voir tous les jeux</a>

    <h2>Derniers supports de la collection</h2>

    <div class="game_grid">
        @foreach($arLatestSupports as $keySupport)
        <div class="game_item">
                <a href="/detail_support/{{ $keySupport->support_id }}">{{ $keySupport->support->support_name }}</a>
                <p>{{ $keySupport->support->support_year }}</p>
        </div>
        @endforeach
    </div>

    <a href="/profil_collection_supports/{{ $objUser->id }}">Voir tous les supports</a>
@stop