@extends('layouts/structure')

@section('titre')
    Edition d'un jeu
@stop

@section('contenu')
<form method="POST" action="/update_collection_jeu?game_id={{ request('game_id')}}&id={{ request('id')}}">
    @csrf
    @method('PUT')
        <label for="note">Note :</label>
        <input type="number" id="note" name="note" min="0" max="10" value="{{ $objCollectionGame->note }}"/>
        <label for="progress">Progression dans le jeu :</label>
        <select id="progress" name="progress">
            @foreach($arProgress as $keyProgress)
            <option value="{{ $keyProgress->progress_id }}" 
                {{ $keyProgress->progress_id == $objCollectionGame->progress_id? 'selected' : '' }}>
                {{ $keyProgress->progress_label }}
            </option>
            @endforeach
        </select>
        <textarea id="comment" name="comment" placeholder="Avis sur le jeu, comment vous l'avez obtenu...">
        {{ $objCollectionGame->comment }}
        </textarea>
        <input type="submit" value="Mettre à jour"/>
    </form>
@stop