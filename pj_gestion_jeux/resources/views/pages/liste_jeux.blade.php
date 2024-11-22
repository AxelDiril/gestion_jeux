@extends('layouts/structure')

@section('titre')
    Liste de jeux
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>Liste de jeux</h1>

    <form method="GET">
        <input type="text" name="nom" placeholder="Nom du jeu..." value="{{ $nom }}">
        <select name="support">
            <option value="tous">Tous supports</option>
            @foreach($arSupports as $keySupport)
                <option value="{{ $keySupport->id }}" 
                {{ $keySupport->id == $support ? 'selected' : '' }}>
                {{ $keySupport->nom }}
                </option>
            @endforeach
        </select>
        <select name="genre">
            <option value="tous">Tous genres</option>
            @foreach($arGenres as $keyGenre)
                <option value="{{ $keyGenre->id }}" 
                {{ $keyGenre->id == $genre ? 'selected' : '' }}>
                {{ $keyGenre->label }}
                </option>
            @endforeach
        </select>
        <select name="annee">
            <option value="toutes">Toutes les années</option>
            @foreach($arAnnees as $keyAnnee)
                <option value="{{ $keyAnnee->date_sortie }}" 
                {{ $keyAnnee->date_sortie == $annee ? 'selected' : '' }}>
                {{ $keyAnnee->date_sortie }}
            </option>
            @endforeach
        </select>
        <select name="ordre">
            <option value="titre" {{ request()->get('ordre') == 'titre' ? 'selected' : '' }}>Ordre alphabetique</option>
            <option value="date_sortie" {{ request()->get('ordre') == 'date_sortie' ? 'selected' : '' }}>Année</option>
            <option value="id_GJ_SUPPORTS" {{ request()->get('ordre') == 'id_GJ_SUPPORTS' ? 'selected' : '' }}>Support</option>
        </select>
        <select name="ordre_sens">
            <option value="asc" {{ request()->get('ordre_sens') == 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ request()->get('ordre_sens') == 'desc' ? 'selected' : '' }}>Décroissant</option>
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