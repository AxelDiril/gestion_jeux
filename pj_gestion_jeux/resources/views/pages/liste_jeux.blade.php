@extends('layouts/structure')

@section('titre')
    Liste de jeux
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('styles/liste_jeux.css') }}">
@stop

@section('contenu')
    <h1>Liste de jeux</h1>

    <form method="GET">
        <select name="support">
            <option value="tous">Tous supports</option>
            @foreach($arSupports as $support)
                <option value="{{ $support->id }}">{{ $support->nom }}</option>
            @endforeach
        </select>
        <select name="annee">
            <option value="toutes">Toutes les années</option>
            @foreach($arAnnees as $annee)
                <option value="{{ $annee->date_sortie }}">{{ $annee->date_sortie }}</option>
            @endforeach
        </select>
        <input type="submit" value="Actualiser"/>
    </form>

    @if($arGames->isEmpty())
        <p>Aucun résultat ne correspond à votre requête</p>
    @else
        <!-- Liste des jeux dans GJ_Games -->
        <div class="game_grid">
            @foreach($arGames as $game)
            <div class="game_item">
                    <p>{{ $game->titre }}</p>
                    <p>{{ $game->date_sortie }}</p>
                    <p>{{ $game->support->nom }}</p>
            </div>
            @endforeach
        </div>
    @endif
@stop