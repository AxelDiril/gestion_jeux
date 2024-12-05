@extends('layouts/structure')

@section('titre')
    Liste des utilisateurs
@stop

@section('contenu')
    <h1>Liste des utilisateurs</h1>

    <!-- Formulaire de filtrage -->
    <form method="GET">
        <!-- Recherche par nom -->
        <input type="text" name="name" placeholder="Nom de l'utilisateur..." value="{{ $strName }}">

        <!-- Filtrer par visibilité -->
        <select name="visibilite">
            <option value="">Sélectionnez la visibilité</option>
            <option value="1" {{ $visibilite === '1' ? 'selected' : '' }}>Visible</option>
            <option value="0" {{ $visibilite === '0' ? 'selected' : '' }}>Invisible</option>
        </select>

        <!-- Filtrer par code -->
        <select name="code">
            <option value="">Sélectionnez le code</option>
            <option value="A" {{ $code === 'A' ? 'selected' : '' }}>A</option>
            <option value="V" {{ $code === 'V' ? 'selected' : '' }}>V</option>
            <option value="U" {{ $code === 'U' ? 'selected' : '' }}>U</option>
        </select>

        <!-- Tri -->
        <select name="order">
            <option value="name" {{ $strOrder === 'name' ? 'selected' : '' }}>Nom</option>
            <option value="created_at" {{ $strOrder === 'created_at' ? 'selected' : '' }}>Date de création</option>
        </select>

        <select name="direction">
            <option value="asc" {{ $strDirection === 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ $strDirection === 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <input type="submit" value="Actualiser"/>
    </form>

    @if($arUsers->isEmpty())
        <p>Aucun utilisateur ne correspond à votre requête</p>
    @else
        <!-- Tableau des utilisateurs -->
        <table class="user_table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                    <th>Visibilité</th>
                    <th>Code</th>
                    <th>Peut Contribuer</th> <!-- Nouvelle colonne "Peut Contribuer" -->
                    <th>Actions</th> <!-- Colonne des actions -->
                </tr>
            </thead>
            <tbody>
                @foreach($arUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>{{ $user->visibilite ? 'Visible' : 'Invisible' }}</td>
                    <td>{{ $user->code }}</td>
                    <td>{{ $user->can_contribute ? 'Oui' : 'Non' }}</td> <!-- Nouvelle colonne "Peut Contribuer" -->
                    <td>
                        <!-- Lien vers la page d'édition -->
                        <a href="{{ url('edit_utilisateur/' . $user->id) }}">Modifier</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop