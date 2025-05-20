<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@include('navbar')

<div class="container mt-5">
    <h1 class="mb-4">Edit Film</h1>
    <hr>

    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('films.update', $film['id']) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul Film</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $film['title']) }}">
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="synopsis" class="form-label">Sinopsis</label>
            <textarea class="form-control" name="synopsis" id="synopsis">{{ old('synopsis', $film['synopsis']) }}</textarea>
            @error('synopsis')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="release_year" class="form-label">Tahun Rilis</label>
            <input type="number" class="form-control" name="release_year" id="release_year" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('release_year', $film['release_year']) }}">
            @error('release_year')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Durasi (menit)</label>
            <input type="number" class="form-control" name="duration" id="duration" min="1" value="{{ old('duration', $film['duration']) }}">
            @error('duration')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="director" class="form-label">Sutradara</label>
            <input type="text" class="form-control" name="director" id="director" value="{{ old('director', $film['director']) }}">
            @error('director')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="rating_avg" class="form-label">Rating Rata-rata (0-10)</label>
            <input type="number" class="form-control" name="rating_avg" id="rating_avg" step="0.1" min="0" max="10" value="{{ old('rating_avg', $film['rating_avg']) }}">
            @error('rating_avg')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Poster Film</label>
            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
            @if ($film['poster_url'])
                <img src="{{ $film['poster_url'] }}" alt="Current Poster" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
            @error('photo')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Pilih Genre</label>
            @forelse ($genres as $genre)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="genre_ids[]" id="genre_{{ $genre['id'] }}" value="{{ $genre['id'] }}" {{ in_array($genre['id'], old('genre_ids', $filmGenreIds)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="genre_{{ $genre['id'] }}">{{ $genre['name'] }}</label>
                </div>
            @empty
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="genre_disabled" disabled>
                    <label class="form-check-label" for="genre_disabled">Tidak ada Genre untuk dipilih</label>
                </div>
            @endforelse
            @error('genre_ids')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Pilih Cast</label>
            @forelse ($casts as $cast)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="cast_ids[]" id="cast_{{ $cast['id'] }}" value="{{ $cast['id'] }}" {{ in_array($cast['id'], old('cast_ids', $filmCastIds)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="cast_{{ $cast['id'] }}">{{ $cast['name'] }}</label>
                </div>
            @empty
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="cast_disabled" disabled>
                    <label class="form-check-label" for="cast_disabled">Tidak ada Cast untuk dipilih</label>
                </div>
            @endforelse
            @error('cast_ids')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mb-3">Perbarui</button>
        <a href="{{ route('films.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
