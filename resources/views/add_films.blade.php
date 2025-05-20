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
        <h1 class="mb-4">Add Film</h1>
        <hr>

        <form method="POST" action="{{route('films.add')}}">
            @csrf
            @method('CREATE')

            <div class="mb-3">
                <label for="title" class="form-label">Film Title</label>
                <input type="text" class="form-control" name="title" id="title">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Synopsis</label>
                <input type="text" class="form-control" name="synopsis" id="synopsis">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Release Year</label>
                <input type="text" class="form-control" name="release_year" id="release_year">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Film Duration</label>
                <input type="text" class="form-control" name="duration" id="duration">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Poster</label>
                <input type="text" class="form-control" name="poster_url" id="poster_url">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Directior</label>
                <input type="text" class="form-control" name="director" id="director">
            </div>

            {{-- TODO Tambahin dropdown cast dan genre --}}
            <div class="mb-3">
                <label for="genre" class="form-label">Pilih Genre</label><br>
                @forelse ($genres as $genre)
                <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            {{$genre['name']}}
                        </label>
                </div>
                @empty
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkDisabled" disabled>
                    <label class="form-check-label" for="checkDisabled">
                        Tidak ada Genre untuk dipilih
                    </label>
                </div>
                @endforelse
            </div>

            <div class="mb-3">
                <label for="cast" class="form-label">Pilih Cast</label><br>
                @forelse ($casts as $cast)
                <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            {{$cast['name']}}
                        </label>
                </div>
                @empty
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkDisabled" disabled>
                    <label class="form-check-label" for="checkDisabled">
                        Tidak ada Cast untuk dipilih
                    </label>
                </div>
                @endforelse
            </div>

            <button type="submit" class="btn btn-primary mb-3">Submit</button><br>
            <a href="{{route('films.index')}}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
