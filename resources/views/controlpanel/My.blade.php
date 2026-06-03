@include('controlpanel.components.header')

<div class="main-content" style="min-height: 896px">
    <section class="section">
        <div class="section-header">
            <h1>My Favorites</h1>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Favorite Movies</h4>
                        </div>

                        <div class="card-body">

                            @if($favorites->count() > 0)

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="120">Poster</th>
                                                <th>Title</th>
                                                <th width="100">Year</th>
                                                <th width="120">Type</th>
                                                <th width="220">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        @foreach($favorites as $movie)
                                            <tr>

                                                <td>
                                                    <img
                                                        src="{{ $movie->poster }}"
                                                        alt="{{ $movie->title }}"
                                                        width="80"
                                                        class="img-fluid rounded">
                                                </td>

                                                <td>
                                                    {{ $movie->title }}
                                                </td>

                                                <td>
                                                    {{ $movie->year }}
                                                </td>

                                                <td>
                                                    <span class="badge badge-primary">
                                                        {{ ucfirst($movie->type) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <a href="{{ route('movies.detail', $movie->imdb_id) }}"
                                                       class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                        Detail
                                                    </a>

                                                    <button
                                                        class="btn btn-danger btn-sm delete-favorite"
                                                        data-imdb="{{ $movie->imdb_id }}">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            @else

                                <div class="text-center py-5">
                                    <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>

                                    <h5 class="text-muted">
                                        No favorites yet
                                    </h5>

                                    <p class="text-muted">
                                        Start adding movies to your favorites list!
                                    </p>

                                    <a href="{{ route('dashboard') }}"
                                       class="btn btn-primary mt-2">
                                        <i class="fas fa-search"></i>
                                        Find your favorite movie
                                    </a>
                                </div>

                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-favorite').forEach(button => {

        button.addEventListener('click', function () {

            if (!confirm('Hapus dari favorite?')) {
                return;
            }

            fetch('/controlpanel/favorites/' + this.dataset.imdb, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }

            })
            .catch(error => {
                console.error(error);
                alert('Terjadi kesalahan.');
            });

        });

    });

});
</script>

@include('controlpanel.components.footer')