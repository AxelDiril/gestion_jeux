@extends('layouts/structure')

@section('titre')
{{ $objSupport->support_name }}
@stop

@section('css', asset('styles/liste_jeux.css'))

@section('contenu')
    @if($iSupportId == null)
        <p>Aucun support n'a été sélectionné</p>
    @else
        <h1>{{ $objSupport->support_name }}</h1>

        <p>Date de sortie : {{ $objSupport->support_year}}</p>
        <p>Description : {{ $objSupport->support_desc }}</p>
    @endif
@stop

