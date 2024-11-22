@extends('layouts/structure')

@section('titre')
    Liste des supports
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>Liste des supports</h1>

    <form method="GET">
        <input type="text" name="nom" placeholder="Nom du support..." value="{{ $nom }}">
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
            <option value="nom" {{ request()->get('ordre') == 'nom' ? 'selected' : '' }}>Ordre alphabetique</option>
            <option value="date_sortie" {{ request()->get('ordre') == 'date_sortie' ? 'selected' : '' }}>Année</option>
        </select>
        <select name="ordre_sens">
            <option value="asc" {{ request()->get('ordre_sens') == 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ request()->get('ordre_sens') == 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <input type="submit" value="Actualiser"/>
    </form>

    @if($arSupports->isEmpty())
        <p>Aucun résultat ne correspond à votre requête</p>
    @else
        <!-- Liste des jeux dans GJ_Supports -->
        <div class="game_grid">
            @foreach($arSupports as $keySupport)
            <div class="game_item">
                    <p>{{ $keySupport->nom }}</p>
                    <p>{{ $keySupport->date_sortie }}</p>
            </div>
            @endforeach
        </div>
    @endif
@stop