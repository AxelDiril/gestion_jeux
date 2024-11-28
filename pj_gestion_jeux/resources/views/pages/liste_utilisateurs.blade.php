@extends('layouts/structure')

@section('titre')
    Liste des utilisateurs
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>Liste des utilisateurs</h1>

    <form method="GET">
        <input type="text" name="support_name" placeholder="Nom du support..." value="{{ $strSupportName}}">
        <select name="support_year">
            <option value="all">Toutes les années</option>
            @foreach($arYears as $keyYear)
                <option value="{{ $keyYear->support_year }}" 
                {{ $keyYear->support_year == $iSupportYear ? 'selected' : '' }}>
                {{ $keyYear->support_year }}
            </option>
            @endforeach
        </select>
        <select name="order">
            <option value="support_name" {{ request()->get('order') == 'support_name' ? 'selected' : '' }}>Ordre alphabetique</option>
            <option value="support_year" {{ request()->get('order') == 'support_year' ? 'selected' : '' }}>Année</option>
        </select>
        <select name="direction">
            <option value="asc" {{ request()->get('direction') == 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ request()->get('direction') == 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <input type="submit" value="Actualiser"/>
    </form>

    @if($arUsers->isEmpty())
        <p>Aucun résultat ne correspond à votre requête</p>
    @else
        <!-- Liste des utilisateurs -->
        <div class="game_grid">
            @foreach($arUsers as $keyUser)
            <div class="game_item">
                <p>{{ $keyUser->name}}</p>
            </div>
            @endforeach
        </div>
    @endif
@stop