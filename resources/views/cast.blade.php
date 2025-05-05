<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            padding: 30px;
            background-color: #f8f9fa;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
<h2>Manajemen Cast</h2>
<div class="table-container">
    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#castModal">Tambah</button>
    <table class="table table-striped table-bordered">
        <thead>
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
        <tr>
            <td>[id]</td>
            <td>[nama]</td>
            <td>[birth_of_date]</td>
            <td>[url]</td>
            <td>[created]</td>
            <td>[updated]</td>
            <td>
                <button class="btn btn-info btn-sm">Edit</button>
                <button class="btn btn-danger btn-sm">Hapus</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</div>

<!-- Pop up gitulah -->
<div class="modal fade" id="castModal" tabindex="-1" aria-labelledby="castModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/cast/store" method="POST">

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

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<?php

?>
