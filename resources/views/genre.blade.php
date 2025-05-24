<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
            crossorigin="anonymous"></script>
    <style>
        body {
            padding: 0px;
            background-color: #f8f9fa;
        }

        .action-btn {
            min-width: 70px;
            height: 30px;
            padding: 2px 8px;
            margin-bottom: 10px;
            font-size: 0.875rem;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .btn-sm {
            padding: 2px 8px;
            font-size: 0.875rem;
        }

    </style>
    <title>Management Genre</title>
</head>
<body>
@include('navbar')
<div class="container mt-5 ">
    <h1 class="mb-4">Manajemen Genre</h1>
{{--    <div class="table-container">--}}
        <div class="d-grid gap-2">
            <button class="btn btn-lg btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#genreCreateModal">Tambah</button>
        </div>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Genre</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($genres as $genre)
                <tr>
                    <td>{{ $genre['id'] }}</td>
                    <td>{{ $genre['name'] }}</td>
                    <td>{{ $genre['created_at'] }}</td>
                    <td>{{ $genre['updated_at'] }}</td>
                    <td>
                        <button
                            class="btn btn-info btn-sm btn-edit action-btn"
                            data-id="{{ $genre['id'] }}"
                            data-name="{{ $genre['name'] }}"
                        >Edit</button>

                        <form action="/genres/{{ $genre['id'] }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-btn"
                                    onclick="return confirm('Genre = {{$genre['name']}}, dengan id = {{$genre['id']}} akan dihapus')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah Genre --}}
    <div class="modal fade" id="genreCreateModal" tabindex="-1" aria-labelledby="genreCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('genres.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="genreCreateModalLabel">Tambah Genre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create-name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Genre --}}
    <div class="modal fade" id="genreEditModal" tabindex="-1" aria-labelledby="genreEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="genreEditForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-header">
                        <h5 class="modal-title" id="genreEditModalLabel">Edit Genre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
{{--    </div>--}}
</div>

@include('footer')

</body>
</html>

<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const genreId = this.getAttribute('data-id')
            const genreName = this.getAttribute('data-name')

            const form = document.getElementById('genreEditForm')
            form.setAttribute('action', `/genres/${genreId}`)
            document.getElementById('edit-name').value = genreName

            const modal = new bootstrap.Modal(document.getElementById('genreEditModal'));
            modal.show();
        });
    });
</script>
