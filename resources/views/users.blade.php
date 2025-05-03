<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap JS dan Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/users.js') }}"></script>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Manajemen Film</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Manajemen Cast</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Manajemen Genre</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Manajemen User</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Manajemen Review</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Login/Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4">Manajemen User</h1>

        <!-- Table User -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                <!-- Data user akan dimasukkan disini menggunakan JS -->
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <small>© 2025 Admin Panel. All rights reserved.</small>
        </div>
    </footer>
</body>
</html>
