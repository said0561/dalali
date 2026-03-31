@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Bidhaa Zangu</h4>
        <a href="{{ route('listings.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Ongeza Mpya
        </a>
    </div>

    <div class="row">
        @forelse($listings as $listing)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <img src="{{ asset($listing->thumbnail) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <span class="badge bg-primary-subtle text-primary rounded-pill mb-2 px-3">
                            {{ $listing->category->name }}
                        </span>
                        <h6 class="fw-bold mb-1">{{ $listing->title }}</h6>
                        <p class="text-success fw-bold small mb-0">Tsh {{ number_format($listing->price) }}</p>
                    </div>
                        <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                            <a href="{{ route('listings.edit', $listing->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1 rounded-pill">
                                <i class="bi bi-pencil me-1"></i> Hariri
                            </a>

                            <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Je, una uhakika unataka kufuta tangazo hili?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                    <i class="bi bi-trash me-1"></i> Futa
                                </button>
                            </form>
                        </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted italic">Bado hujapandisha bidhaa yoyote.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection