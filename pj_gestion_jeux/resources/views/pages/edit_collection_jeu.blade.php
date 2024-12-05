@extends('layouts.structure')

@section('titre')
    Modifier le jeu
@stop

@section('contenu')
    <h1>Modifier le jeu : {{ $objCollectionGame->game->game_name }}</h1>

    <form method="POST" action="{{ url('update_collection_jeu/'.$objCollectionGame->game_id.'/'.$objCollectionGame->id) }}">
        @csrf
        @method('PUT')
        <!-- Champ pour la note (de 0 à 10) -->
        <div>
            <label for="note">Note</label>
            <input type="number" name="note" value="{{ old('note', $objCollectionGame->note) }}" min="0" max="10">
        </div>
        <!-- Champs pour le commentaire -->
        <div>
            <label for="comment">Commentaire</label>
            <input type="text" name="comment" value="{{ old('comment', $objCollectionGame->comment) }}">
        </div>
        <!-- Sélection de la progression -->
        <div>
            <label for="progress_id">Progression</label>
            <select name="progress_id">
                <!-- Affiche toutes les progressions de GJ_progressions -->
                @foreach($arProgressions as $progression)
                    <option value="{{ $progression->progress_id }}" {{ $objCollectionGame->progress_id == $progression->progress_id ? 'selected' : '' }}>
                        {{ $progression->progress_label }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit">Mettre à jour</button>
    </form>

@stop
