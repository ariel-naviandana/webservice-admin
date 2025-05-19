<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('films*') ? 'active' : '' }}" href="/films">Manajemen Film</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('casts*') ? 'active' : '' }}" href="/casts">Manajemen Cast</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('genres*') ? 'active' : '' }}" href="/genres">Manajemen Genre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="/users">Manajemen User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('reviews*') ? 'active' : '' }}" href="/reviews">Manajemen Review</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login/Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
