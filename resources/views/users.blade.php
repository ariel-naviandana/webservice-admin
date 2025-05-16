    <!-- resources/views/users.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Header -->
    @include('navbar')

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4">Manajemen User</h1>

        @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif

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
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['role'] }}</td>
                        <td>
                            <a href="{{ route('users.index', ['edit_id' => $user['id']]) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form  action="/users/{{ $user['id'] }}" method="POST"class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada user ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Edit User -->
    @if(isset($editingUser))
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ isset($editingUser) ? route('users.update', $editingUser['id']) : '#' }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">Name</label>
                            <input type="text" id="editUserName" class="form-control" value="{{ $editingUser['name'] ?? '' }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" id="editUserEmail" class="form-control" value="{{ $editingUser['email'] ?? '' }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role</label>
                            <select id="editUserRole" name="role" class="form-select">
                                <option value="admin" {{ isset($editingUser['role']) && $editingUser['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ isset($editingUser['role']) && $editingUser['role'] == 'user' ? 'selected' : '' }}>User</option>
                                <option value="critic" {{ isset($editingUser['role']) && $editingUser['role'] == 'critic' ? 'selected' : '' }}>Critic</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.onload = function () {
            var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            myModal.show();
        };
    </script>
    @endif

    <!-- Footer -->
    @include('footer')
</body>
</html>
