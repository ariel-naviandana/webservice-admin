<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manajemen Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    @include('navbar')

    <div class="container mt-5">
        <h1 class="mb-4">Manajemen Film</h1>
        <hr>
        <div class="d-grid gap-2">
            <a href="{{route('films.add')}}" class="btn btn-lg btn-primary mb-4">Tambah Film</a>
        </div>

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th class="col-2">Judul</th>
                    <th class="col-3">Sinopsis</th>
                    <th>Tahun Rilis</th>
                    <th>Durasi</th>
                    <th>Poster</th>
                    <th>Direktor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($films as $film)
                <tr>
                    <td>{{$film['id']}}</td>
                    <td>{{$film['title']}}</td>
                    <td>{{$film['synopsis']}}</td>
                    <td>{{$film['release_year']}}</td>
                    <td>{{$film['duration']}}</td>
                    <td><img src="{{$film['poster_url'] ?? 'https://i.pinimg.com/236x/56/2e/be/562ebed9cd49b9a09baa35eddfe86b00.jpg'}}" alt="Poster" height="50px"></td>
                    <td>{{$film['director']}}</td>
                    <td>
                        <a href="{{ route('reviews.index', ['film_id' => $film['id']]) }}" class="btn btn-success">Lihat Review</a>
                        <a href="{{route('films.edit', $film['id'])}}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('films.destroy', $film['id']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus film ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Data tidak ada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
