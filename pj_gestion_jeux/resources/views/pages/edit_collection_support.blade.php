@extends('layouts.structure')

@section('titre')
    Modifier le commentaire
@stop

@section('contenu')
    <h1>Modifier le commentaire du support : {{ $objCollectionSupport->support->support_name }}</h1>

    <form method="POST" action="{{ url('update_collection_support/'.$objCollectionSupport->support_id.'/'.$objCollectionSupport->id) }}">
        @csrf
        @method('PUT')
        
        <!-- Champ pour le commentaire -->
        <div>
            <label for="comment">Commentaire</label>
            <input type="text" name="comment" value="{{ old('comment', $objCollectionSupport->comment) }}">
        </div>
        
        <button type="submit">Mettre à jour</button>
    </form>

@stop
