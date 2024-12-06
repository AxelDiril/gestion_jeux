<h1>Projet Gestion Jeux</h1>
<a href="/liste_jeux">Jeux</a>
<a href="/liste_supports">Supports</a>
<a href="/liste_utilisateurs">Membres</a>

@auth
<a href="/profil/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <input type="submit" value="Se déconnecter">
</form>
@else
<a href="{{ route('login') }}">Se connecter</a>
@endif