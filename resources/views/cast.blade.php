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
    <div class="d-grid gap-2">
        <button id="btn-add" class="btn btn-lg btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#castCreateModal">Tambah data cast</button>
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
                <td>
                    <img src="{{ $cast['photo_url'] }}" alt="Foto Cast" style="max-height: 60px;">
                </td>\\
                <td>{{ $cast['created_at'] }}</td>
                <td>{{ $cast['updated_at'] }}</td>
                <td>
                    <button type="button"
                            class="btn btn-info btn-edit btn-sm action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#castEditModal"
                            data-id="{{ $cast['id'] }}"
                            data-name="{{ $cast['name'] }}"
                            data-dob="{{ $cast['birth_date'] }}">
                        Edit</button>

                    <form action="/casts/{{ $cast['id'] }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm action-btn"
                                onclick="return confirm('Cast = {{$cast['name']}}, dengan id = {{$cast['id']}} akan dihapus')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="castCreateModal" tabindex="-1" aria-labelledby="castModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('casts.store') }}" method="POST">

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
                        <input type="date" class="form-control" id="edit-dob" name="date_of_birth">
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit-photo" name="img" accept="image/*">
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
            <form id="castEditForm" method="POST" enctype="multipart/form-data">
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
                        <label for="edit-dob" class="form-label">Tanggal lahir</label>
                        <input type="date" class="form-control" id="edit-dob" name="date_of_birth" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-photo" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit-photo" name="img">
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

<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            const castId = this.getAttribute('data-id')
            const castName = this.getAttribute('data-name')
            const birthdate = this.getAttribute('data-dob')

            const form = document.getElementById('castEditForm')
            form.setAttribute('action', `/casts/${castId}`)

            document.getElementById('edit-name').value = castName
            document.getElementById('edit-dob').value = birthdate

            const modal = new bootstrap.Modal(document.getElementById('castEditModal'));
            modal.show();
        });
    });
</script>
