@extends('layouts/structure')

@section('titre')
    Modification de l'utilisateur
@stop

@section('contenu')
    <h1>Édition de l'utilisateur : {{ $objUser->name }}</h1>

    <!-- Formulaire d'édition -->
    <form method="POST" action="/update_utilisateur/{{ $objUser->id }}">
        @csrf
        @method('PUT')

        <!-- Champ Code -->
        <div>
            <label for="code">Code</label>
            <select name="code" id="code">
                <option value="A" {{ $objUser->code == 'A' ? 'selected' : '' }}>A</option>
                <option value="V" {{ $objUser->code == 'V' ? 'selected' : '' }}>V</option>
                <option value="U" {{ $objUser->code == 'U' ? 'selected' : '' }}>U</option>
            </select>
        </div>

        <!-- Champ Can Contribute -->
        <div>
            <label for="can_contribute">Peut contribuer</label>
            <select name="can_contribute" id="can_contribute">
                <option value="1" {{ $objUser->can_contribute == 1 ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ $objUser->can_contribute == 0 ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div>
            <button type="submit">Mettre à jour</button>
        </div>
    </form>
@stop
