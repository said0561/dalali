@extends('layouts.frontend')

@section('content')
<section class="hero-section text-white py-5" style="background: linear-gradient(45deg, #0d6efd, #003366);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                <h1 class="display-4 fw-bold mb-3 lh-sm">Huduma Zote za Udalali Kiganjani Mwako</h1>
                <p class="lead mb-4 opacity-90 fw-light">Pata Nyumba, Viwanja, Ofisi, na Magari kutoka kwa madalali walioidhinishwa Tanzania.</p>
                
                <div class="d-flex justify-content-center justify-content-lg-start gap-4">
                    <div class="text-center">
                        <h2 class="fw-bold mb-0">{{ $listingsCount }}+</h2>
                        <small class="text-uppercase" style="font-size: 0.7rem;">Bidhaa</small>
                    </div>
                    <div class="vr bg-white opacity-50"></div>
                    <div class="text-center">
                        <h2 class="fw-bold mb-0">{{ $brokersCount }}+</h2>
                        <small class="text-uppercase" style="font-size: 0.7rem;">Madalali</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 offset-lg-1">
                <div class="card search-card border-0 shadow-lg p-4 rounded-4">
                    <h5 class="fw-bold mb-4 text-center text-primary">Tafuta Bidhaa/Huduma</h5>
                    <form action="{{ route('listings.search') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">MKOA</label>
                            <select name="region" class="form-select form-select-lg rounded-pill border-primary-subtle shadow-sm">
                                <option value="">Mikoa yote Tanzania...</option>
                                @foreach(\App\Models\Region::all() as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">UNAITAFUTA NINI?</label>
                            <select name="category" class="form-select form-select-lg rounded-pill border-primary-subtle shadow-sm">
                                <option value="">Aina zote...</option>
                                @foreach(\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <input type="text" name="keyword" class="form-control rounded-pill px-4 shadow-sm" placeholder="Andika neno (Mfano: Nyumba, Gari...)">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 shadow fw-bold border-0 text-white">
                            <i class="bi bi-search me-2"></i> TAFUTA SASA
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row g-3 text-center justify-content-center">
        @foreach($categories as $cat)
        <div class="col-4 col-md-2">
            <a href="{{ route('listings.search', ['category' => $cat->id]) }}" class="text-decoration-none text-dark">
                <div class="p-3 bg-white shadow-sm rounded-4 border-bottom border-primary border-3 h-100 transition-hover">
                    <i class="bi {{ $cat->icon ?? 'bi-grid' }} fs-2 text-primary"></i>
                    <p class="small fw-bold mt-2 mb-0 text-truncate">{{ $cat->name }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1">Bidhaa za Hivi Karibuni</h3>
            <p class="text-muted mb-0">Bidhaa zilizohakikiwa na madalali wetu</p>
        </div>
        <a href="{{ route('listings.search') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Zote <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row g-4">
        @forelse($latestListings as $listing)
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 listing-card">
                <div class="position-relative">
                    <img src="{{ asset($listing->thumbnail) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $listing->title }}">
                    <span class="position-absolute top-0 start-0 m-3 badge bg-primary rounded-pill px-3 shadow-sm">
                        Tsh {{ number_format($listing->price) }}
                    </span>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <small class="text-primary fw-bold text-uppercase" style="font-size: 0.75rem;">
                            {{ $listing->category->name }}
                        </small>
                        <span class="mx-2 text-muted opacity-50">|</span>
                        <small class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $listing->region->name }}</small>
                    </div>
                    <h6 class="fw-bold text-dark text-truncate">{{ $listing->title }}</h6>
                    <a href="{{ route('listings.show', $listing->slug) }}" class="btn btn-light btn-sm w-100 rounded-pill mt-2 fw-bold text-primary border-primary-subtle">Angalia Zaidi</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Hakuna bidhaa mpya iliyohakikiwa kwa sasa.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection