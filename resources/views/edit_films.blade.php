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

        <form method="POST" action="{{route('films.update', $film['id'])}}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Film Title</label>
                <input type="text" class="form-control" name="title" id="title" value="{{old('title', $film['title'])}}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Synopsis</label>
                <input type="text" class="form-control" name="synopsis" id="synopsis" value="{{old('synopsis', $film['synopsis'])}}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Release Year</label>
                <input type="text" class="form-control" name="release_year" id="release_year" value="{{old('release_year', $film['release_year'])}}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Film Duration</label>
                <input type="text" class="form-control" name="duration" id="duration" value="{{old('duration', $film['duration'])}}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Poster</label>
                <input type="text" class="form-control" name="poster_url" id="poster_url" value="{{old('poster_url', $film['poster_url'])}}">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Directior</label>
                <input type="text" class="form-control" name="director" id="director" value="{{old('director', $film['director'])}}">
            </div>

            {{-- TODO Tambahin dropdown cast dan genre --}}
            <button type="submit" class="btn btn-primary mb-3">Submit</button><br>
            <a href="{{route('films.index')}}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
