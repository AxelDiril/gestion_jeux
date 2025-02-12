@extends('layouts/structure')

@section('titre')
    Liste des supports
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    <h1>Liste des supports</h1>

    <form method="GET">
        <!-- Recherche par nom -->
        <input type="text" name="support_name" placeholder="Nom du support..." value="{{ $strSupportName}}">
        <!-- Filtre par année -->
        <select name="support_year"">
            <option value="all">Toutes les années</option>
            @foreach($arYears as $keyYear)
                <option value="{{ $keyYear->support_year }}" 
                {{ $keyYear->support_year == $iSupportYear ? 'selected' : '' }}>
                {{ $keyYear->support_year }}
            </option>
            @endforeach
        </select>
        <!-- Tri -->
        <select name="order">
            <option value="support_name" {{ request()->get('order') == 'support_name' ? 'selected' : '' }}>Ordre alphabetique</option>
            <option value="support_year" {{ request()->get('order') == 'support_year' ? 'selected' : '' }}>Année</option>
        </select>
        <select name="direction">
            <option value="asc" {{ request()->get('direction') == 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ request()->get('direction') == 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <input type="submit" value="Actualiser" class="btn btn-info"/>
    </form>

    @if($arSupports->isEmpty())
        <p>Aucun résultat ne correspond à votre requête</p>
    @else
        <!-- Liste des supports dans GJ_Supports -->
        <div class="container my-5"">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                @foreach($arSupports as $keySupport)
                    <div class="col">
                        <div class="card">
                            <img src="/img/support_pics/{{ $keySupport->support_pic }}" class="card-img-top" width="100" height="100">
                            <div class="card-body">
                                <a href="/detail_support/{{ $keySupport->support_id }}" class="card-title">{{ $keySupport->support_name }}</a>
                                <p class="card-text">{{ $keySupport->support_year }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@stop