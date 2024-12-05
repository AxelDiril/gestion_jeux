<h1>Projet Gestion Jeux</h1>
<a href="/liste_jeux">Liste des jeux</a>
<a href="/liste_jeux">Liste des supports</a>

@auth
<a href="{{ route('logout') }}">Se déconnecter</a>
@else
<a href="{{ route('login') }}">Se connecter</a>
@endif