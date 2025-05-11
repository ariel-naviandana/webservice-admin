<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding: 30px;
            background-color: #f8f9fa;
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
<h2>Manajemen Genre</h2>
<div class="table-container">
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#genreModal">Tambah</button>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Genre</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>[id]</td>
            <td>[name]</td>
            <td>[created_at]</td>
            <td>[updated_at]</td>
            <td>
                <button class="btn btn-info btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Hapus</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</div>

<div class="modal fade" id="genreModal" tabindex="-1" aria-labelledby="genreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/cast/store" method="POST">

                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="castModalLabel">Tambah Genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
