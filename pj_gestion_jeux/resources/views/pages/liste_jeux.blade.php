@extends('layouts/structure')

@section('titre')
    Liste des jeux
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>Liste de jeux</h1>

    <form method="GET">
        <!-- Recherche par nom -->
        <input type="text" name="game_name" placeholder="Nom du jeu..." value="{{ $strGameName }}">
        <!-- Filtre par support -->
        <select name="support_id" class="form-select form-select-sm">
            <option value="all">Tous supports</option>
            @foreach($arSupports as $keySupport)
                <option value="{{ $keySupport->support_id }}" 
                {{ $keySupport->support_id == $iSupportId ? 'selected' : '' }}>
                {{ $keySupport->support_name }}
                </option>
            @endforeach
        </select>
        <!-- Filtre par genre -->
        <select name="genre_id" class="form-select form-select-sm">
            <option value="all">Tous genres</option>
            @foreach($arGenres as $keyGenre)
                <option value="{{ $keyGenre->genre_id }}" 
                {{ $keyGenre->genre_id == $iGenreId ? 'selected' : '' }}>
                {{ $keyGenre->genre_label }}
                </option>
            @endforeach
        </select>
        <!-- Filtre par année -->
        <select name="game_year" class="form-select form-select-sm">
            <option value="all">Toutes les années</option>
            @foreach($arYears as $keyYear)
                <option value="{{ $keyYear->game_year }}" 
                {{ $keyYear->game_year == $iGameYear ? 'selected' : '' }}>
                {{ $keyYear->game_year }}
            </option>
            @endforeach
        </select>
        <!-- Tri -->
        <select name="order" class="form-select form-select-sm">
            <option value="game_name" {{ request()->get('Order') == 'game_nom' ? 'selected' : '' }}>Ordre alphabetique</option>
            <option value="game_year" {{ request()->get('Order') == 'game_year' ? 'selected' : '' }}>Année</option>
            <option value="support_id" {{ request()->get('Order') == 'support_ids' ? 'selected' : '' }}>Support</option>
        </select>
        <select name="direction" class="form-select form-select-sm">
            <option value="asc" {{ request()->get('direction') == 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ request()->get('direction') == 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <input type="submit" value="Actualiser" class="btn btn-custom mx-2 btn-info"/>
    </form>

    @if($arGames->isEmpty())
        <p>Aucun résultat ne correspond à votre requête</p>
    @else
        <!-- Liste des jeux dans GJ_Games -->
        <div class="container">
            @foreach($arGames as $keyGame)
            <div class="item">
                <a href="/detail_jeu/{{ $keyGame->game_id }}">{{ $keyGame->game_name }}</a>
                <p>{{ $keyGame->game_year }}</p>
                <p>{{ $keyGame->support->support_name }}</p>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Liens de pagination -->
    <div class="pagination">
        {{ $arGames->links() }}
    </div>
@stop