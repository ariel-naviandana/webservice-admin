<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <title>Manajemen Cast</title>
    <style>
        body { padding: 0px; background-color: #f8f9fa; }
        .action-btn { min-width: 70px; height: 30px; padding: 2px 8px; margin-bottom: 10px; font-size: 0.875rem; }
        .table thead { background-color: #343a40; color: white; }
        .btn-sm { padding: 2px 8px; font-size: 0.875rem; }
    </style>
</head>
<body>
@include('navbar')
<div class="container mt-5">
    <h1 class="mb-4">Manajemen Cast</h1>
    <div class="d-grid gap-2">
        <button id="btn-add" class="btn btn-lg btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#castModal">Tambah data cast</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    @if(session('message'))
        <div class="alert alert-info mb-4">{{ session('message') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                    <img src="{{$cast['photo_url'] ?? 'https://i.pinimg.com/236x/56/2e/be/562ebed9cd49b9a09baa35eddfe86b00.jpg'}}" style="height: 50px; width: 50px; border-radius: 50%;" alt="img">
                </td>
                <td>{{ $cast['created_at'] }}</td>
                <td>{{ $cast['updated_at'] }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#castEditModal"
                            data-id="{{ $cast['id'] }}"
                            data-name="{{ $cast['name'] }}"
                            data-birth_date="{{ $cast['birth_date'] }}"
                            data-photo_url="{{ $cast['photo_url'] }}">Edit</button>
                    <form action="{{ route('casts.destroy', $cast['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm action-btn">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- Modal Tambah Cast -->
<div class="modal fade" id="castModal" tabindex="-1" aria-labelledby="castModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('casts.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="date" class="form-control" id="dob" name="birth_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="img_url" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="img_url" name="photo" accept="image/*">
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
<!-- Modal Edit Cast -->
<div class="modal fade" id="castEditModal" tabindex="-1" aria-labelledby="castEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="castEditForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
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
                        <label for="edit-dob" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="edit-dob" name="birth_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-photo" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit-photo" name="photo" accept="image/*">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('castEditModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const birth_date = button.getAttribute('data-birth_date');
            const form = document.getElementById('castEditForm');
            form.action = `/casts/${id}`;
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-dob').value = birth_date;
        });
    });
</script>
@include('footer')
</body>
</html>
