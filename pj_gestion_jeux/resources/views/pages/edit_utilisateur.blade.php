@extends('layouts/structure')

@section('titre')
    Édition de l'utilisateur
@stop

@section('css', asset('styles/edition_utilisateur.css'))

@section('contenu')
    <h1>Édition de l'utilisateur : {{ $user->name }}</h1>

    <!-- Formulaire d'édition -->
    <form method="POST" action="/update_utilisateur/{{ $user->id }}">
        @csrf
        @method('PUT')

        <!-- Champ Code -->
        <div>
            <label for="code">Code</label>
            <select name="code" id="code">
                <option value="A" {{ $user->code == 'A' ? 'selected' : '' }}>A</option>
                <option value="V" {{ $user->code == 'V' ? 'selected' : '' }}>V</option>
                <option value="U" {{ $user->code == 'U' ? 'selected' : '' }}>U</option>
            </select>
        </div>

        <!-- Champ Can Contribute -->
        <div>
            <label for="can_contribute">Peut contribuer</label>
            <select name="can_contribute" id="can_contribute">
                <option value="1" {{ $user->can_contribute == 1 ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ $user->can_contribute == 0 ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div>
            <button type="submit">Mettre à jour</button>
        </div>
    </form>
@stop
