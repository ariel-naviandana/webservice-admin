<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    @include('navbar')

    <div class="container mt-5 mb-4">
        <h1 class="mb-4">Dashboard</h1>

        <p>Selamat datang kembali Admin!</p>

        {{--
            Berisi statistika biasa, misalnya:
            1. Jumlah Film
            2. Jumlah Review
            3. Jumlah Genre atau mungkin
        --}}
        <hr>

        <h2 class="mb-4">Statistik</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Film Bulan ini</h5>
                        <h2 class="text-primary">15</h2>
                        <p class="text-muted">Film</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Film</h5>
                        <h2 class="text-primary">1.234</h2>
                        <p class="text-muted">Film</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Review Bulan ini</h5>
                        <h2 class="text-primary">1.500</h2>
                        <p class="text-muted">Review</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Review</h5>
                        <h2 class="text-primary">1.234</h2>
                        <p class="text-muted">Review</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengguna</h5>
                        <h2 class="text-primary">2.456</h2>
                        <p class="text-muted">Pengguna</p>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        {{-- List Film yang ada --}}
        <div class="container">
            <h2 class="mb-4">List Film</h2>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th class="col-4">Sinopsis</th>
                        <th>Tahun Rilis</th>
                        <th>Durasi</th>
                        <th>Poster</th>
                        <th>Direktor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0</td>
                        <td>La La Land</td>
                        <td>When Sebastian, a pianist, and Mia, an actress, follow their passion and achieve success in their respective fields, they find themselves torn between their love for each other and their careers.</td>
                        <td>2016</td>
                        <td>2h 8m</td>
                        <td>poster</td>
                        <td>Damien Chazelle</td>
                    </tr>
                    @forelse ($films as $film)
                        <tr>
                            <td>{{ $film['id']}}</td>
                            <td>{{ $film['title']}}</td>
                            <td>{{ $film['synopsis']}}</td>
                            <td>{{ $film['release_year']}}</td>
                            <td>{{ $film['duration']}} Menit</td>
                            <td>poster</td>
                            <td>{{ $film['director']}}</td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



      @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
