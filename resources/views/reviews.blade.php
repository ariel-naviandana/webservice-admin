<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    @include('navbar')

    <div class="container mt-5">
        <h1 class="mb-4">Manajemen Review</h1>

        @if(session('message'))
            <div class="alert alert-info">{{ session('message') }}</div>
        @endif

        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Film</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Is Critic</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review['id'] }}</td>
                        <td>
                            {{ collect($films)->firstWhere('id', $review['film_id'])['title'] ?? 'N/A' }}
                        </td>
                        <td>
                            {{ collect($users)->firstWhere('id', $review['user_id'])['name'] ?? 'N/A' }}
                        </td>
                        <td>{{ $review['rating'] }}</td>
                        <td>{{ $review['comment'] }}</td>
                        <td>{{ $review['is_critic'] ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('reviews.index', ['edit_id' => $review['id']]) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="/reviews/{{ $review['id'] }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada review ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($editingReview))
    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('reviews.update', $editingReview['id']) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Film</label>
                            <input type="text" class="form-control" value="{{ collect($films)->firstWhere('id', $editingReview['film_id'])['title'] ?? '' }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User</label>
                            <input type="text" class="form-control" value="{{ collect($users)->firstWhere('id', $editingReview['user_id'])['name'] ?? '' }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <input type="number" step="0.1" class="form-control" name="rating" value="{{ $editingReview['rating'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Komentar</label>
                            <textarea class="form-control" name="comment" rows="3">{{ $editingReview['comment'] }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="is_critic" class="form-label">Is Critic</label>
                            <select name="is_critic" class="form-select">
                                <option value="1" {{ $editingReview['is_critic'] ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$editingReview['is_critic'] ? 'selected' : '' }}>No</option>
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
            var modal = new bootstrap.Modal(document.getElementById('editReviewModal'));
            modal.show();
        };
    </script>
    @endif

    @include('footer')

</body>
</html>
