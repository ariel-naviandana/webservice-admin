<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
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

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .btn-sm {
            padding: 2px 8px;
            font-size: 0.875rem;
        }
    </style>

    <title>Management Cast</title>
</head>
<body>
@include('navbar')
<div class="container mt-5">
<h1 class="mb-4">Manajemen Cast</h1>
{{--<div class="table-container">--}}
    <div class="d-grid gap-2">
        <button id="btn-add" class="btn btn-lg btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#castModal">Tambah data cast</button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date of birth</th>
            <th>Img URL</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($casts as $cast)
        <tr>
            <td>{{ $cast['id'] }}</td>
            <td>{{ $cast['name'] }}</td>
            <td>{{ $cast['birth_date'] }}</td>
            <td>{{ $cast['photo_url'] }}</td>
            <td>{{ $cast['created_at'] }}</td>
            <td>{{ $cast['updated_at'] }}</td>
            <td>
                <button type="button" class="btn btn-info btn-sm action-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#genreModal">Edit</button>

                <button class="btn btn-danger btn-sm action-btn">Hapus</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
{{--</div>--}}
</div>

<!-- Pop up gitulah -->
<div class="modal fade" id="castModal" tabindex="-1" aria-labelledby="castModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/casts/store" method="POST">

                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="castModalLabel">Tambah Cast</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="dob" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="dob" name="date_of_birth" required>
                    </div>

                    <div class="mb-3">
                        <label for="img_url" class="form-label">URL Gambar</label>
                        <input type="file" class="form-control" id="img_url" name="img_url" accept="image/*">
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

{{-- Modal Edit Cast --}}
<div class="modal fade" id="castEditModal" tabindex="-1" aria-labelledby="castEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="castEditForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 class="modal-title" id="castEditModalLabel">Edit Cast</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Tanggal lahir</label>
                        <input type="date" class="form-control" id="edit-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit-name" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@include('footer')
</body>
</html>
