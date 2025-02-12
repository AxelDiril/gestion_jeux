@extends('layouts/structure')

@section('titre')
    {{ $objSupport->support_name }}
@stop

@section('contenu')
    <h1>{{ $objSupport->support_name }}</h1>

    <p><b>Date de sortie :</b> {{ $objSupport->support_year}}</p>
    <p><b>Description :</b> {{ $objSupport->support_desc }}</p>
    <p><b>Possédé par :</b>
        @if(($objSupport->owned_by) > 0)
            {{ $objSupport->owned_by }} utilisateur(s)
        @else
            Personne
        @endif
    </p>
    <!-- Change le lien si l'utilisateur connecté possède déjà le jeu ou non -->
    @auth
        @if($bOwned == true)
            <a href="/delete_collection_jeu/{{ $objSupport->support_id }} class="btn btn-info"">Retirer de la collection</a>
        @else
            <a href="/ajout_jeu/{{ $objSupport->support_id }}" class="btn btn-info">Ajouter à la collection</a>
        @endif
    @endif
    <a href="/liste_supports" class="btn btn-info">Retour à la liste des supports</a>
@stop

