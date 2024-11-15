<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de jeux</title>
</head>
<body>
    <h1>Liste de jeux</h1>

    <form>
        <input type="text"/>
        <input type="submit" value="Rechercher"/>
    </form>

    <!-- Liste des jeux dans GJ_Games -->
    <table border="1">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Date Sortie</th>
                <th>Support</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jeux as $jeu)
            <tr>
                <td>{{ $jeu->titre }}</td>
                <td>{{ $jeu->description }}</td>
                <td>{{ $jeu->date_sortie }}</td>
                <td>{{ $jeu->support->nom ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
