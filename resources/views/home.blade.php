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

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="mb-4">Dashboard</h1>

    <p>Selamat datang kembali Admin!</p>
    <hr>

    <h2 class="mb-4">Statistik</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Film</h5>
                    <h2 class="text-primary">{{$totalFilm}}</h2>
                    <p class="text-muted">Film</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Review</h5>
                    <h2 class="text-primary">{{$totalReview}}</h2>
                    <p class="text-muted">Review</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <h2 class="text-primary">{{$totalUser}}</h2>
                    <p class="text-muted">Pengguna</p>
                </div>
            </div>
        </div>
    </div>

    <hr>

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
                <th>Direktor</th>
                <th>Rating Average</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($films as $film)
                <tr>
                    <td>{{ $film['id']}}</td>
                    <td>{{ $film['title']}}</td>
                    <td>{{ $film['synopsis']}}</td>
                    <td>{{ $film['release_year']}}</td>
                    <td>{{ $film['duration']}} Menit</td>
                    <td>{{ $film['director']}}</td>
                    <td>{{ $film['rating_avg']}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Data tidak ada</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
