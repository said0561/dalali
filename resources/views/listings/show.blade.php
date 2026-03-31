@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div id="listingCarousel" class="carousel slide shadow-sm rounded-4 overflow-hidden" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset($listing->thumbnail) }}" class="d-block w-100" style="height: 450px; object-fit: cover;">
                    </div>
                    @foreach($listing->images as $img)
                    <div class="carousel-item">
                        <img src="{{ asset($img->image_path) }}" class="d-block w-100" style="height: 450px; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#listingCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#listingCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <span class="badge bg-primary-subtle text-primary rounded-pill mb-2 px-3 align-self-start">{{ $listing->category->name }}</span>
                <h2 class="fw-bold text-dark mb-3">{{ $listing->title }}</h2>
                <h3 class="text-success fw-bold mb-4">Tsh {{ number_format($listing->price) }}</h3>
                
                <div class="d-flex gap-3 mb-4">
                    <div class="p-2 bg-light rounded-3 flex-fill text-center">
                        <small class="text-muted d-block small">MKOA</small>
                        <span class="fw-bold">{{ $listing->region->name }}</span>
                    </div>
                    <div class="p-2 bg-light rounded-3 flex-fill text-center">
                        <small class="text-muted d-block small">DALALI</small>
                        <span class="fw-bold">{{ $listing->user->name }}</span>
                    </div>
                </div>

                <h6 class="fw-bold">Maelezo:</h6>
                <p class="text-muted mb-5">{{ $listing->description }}</p>

                <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-success btn-lg w-100 rounded-pill py-3 fw-bold shadow">
                    <i class="bi bi-whatsapp me-2"></i> AGIZA/ULIZIA KWA WHATSAPP
                </a>
                <p class="text-center mt-3 small text-muted">Mawasiliano yote yanapita ofisi kuu.</p>
            </div>
        </div>
    </div>
</div>
@endsection