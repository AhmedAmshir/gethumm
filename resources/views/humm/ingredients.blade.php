@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Ingredients <small>({{ count($ingredients) }})</small>
            </div>
            <div class="card-body">
                @forelse ($ingredients as $ingredient)
                    <article class="mb-3">
                        <h2>{{ $ingredient['name'] }}</h2> / Created At: {{ $ingredient['created_at'] }}

                        <p class="m-0">{{ $ingredient['supplier'] }}</p>

                        <div>
                            <span class="badge badge-light">{{ $ingredient['measure'] }}</span>
                        </div>
                    </article>
                @empty
                    <p>No ingredients found</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
