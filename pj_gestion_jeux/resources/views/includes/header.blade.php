<div class="d-flex justify-content-between align-items-center">
    <h1>Gestion</h1>
    <div class="d-flex flex-wrap">
        <a href="/liste_jeux" class="btn btn-custom mx-2">Jeux</a>
        <a href="/liste_supports" class="btn btn-custom mx-2">Supports</a>
        <a href="/liste_utilisateurs" class="btn btn-custom mx-2">Membres</a>

        @auth
            @if ( Auth::user()->code == "A" || Auth::user()->code == "V")
                <a href="/liste_utilisateurs_admin" class="btn btn-custom mx-2">Modération</a>
            @endif
            <a href="/profil/{{ Auth::user()->id }}" class="btn btn-custom mx-2">Profil</a>

            <!-- Convert logout button to a link -->
            <a href="{{ route('logout') }}" class="btn btn-custom mx-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter</a>
            
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-custom mx-2">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-custom mx-2">S'inscrire</a>
        @endif
    </div>
</div>