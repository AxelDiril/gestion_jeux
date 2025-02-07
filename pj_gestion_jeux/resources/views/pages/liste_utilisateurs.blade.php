@extends('layouts/structure')

@section('titre')
    Liste des utilisateurs
@stop

@section('contenu')
    <h1>Liste des utilisateurs</h1>

    <form method="GET">
        <!-- Recherche par nom -->
        <input type="text" name="name" placeholder="Nom de l'utilisateur..." value="{{ $strName }}">

        <!-- Tri -->
        <select name="order">
            <option value="name" {{ $strOrder === 'name' ? 'selected' : '' }}>Nom</option>
            <option value="created_at" {{ $strOrder === 'created_at' ? 'selected' : '' }}>Date de création</option>
        </select>

        <select name="direction">
            <option value="asc" {{ $strDirection === 'asc' ? 'selected' : '' }}>Croissant</option>
            <option value="desc" {{ $strDirection === 'desc' ? 'selected' : '' }}>Décroissant</option>
        </select>

        <input type="submit" value="Actualiser">
    </form>

    @if($arUsers->isEmpty())
        <p>Aucun utilisateur ne correspond à votre requête</p>
    @else

        <table class="user_table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <!-- Liste des utilisateurs de GJ_users ayant un profil public -->
                @foreach($arUsers as $user)
                <tr>
                    <td><a href="/profil/{{ $user->id }}/">{{ $user->name }}</a></td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop
