<!-- resources/views/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/home">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/films">Manajemen Film</a></li>
                <li class="nav-item"><a class="nav-link" href="/cast">Manajemen Cast</a></li>
                <li class="nav-item"><a class="nav-link" href="/genre">Manajemen Genre</a></li>
                <li class="nav-item"><a class="nav-link" href="/users">Manajemen User</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="#">Manajemen Review</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="#">Login/Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
