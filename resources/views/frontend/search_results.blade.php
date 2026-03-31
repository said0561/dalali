@extends('layouts.frontend')

@section('content')
<div class="bg-light py-4 border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-0">Matokeo ya Utafutaji</h4>
                <p class="text-muted mb-0">Tumepata bidhaa <span class="text-primary fw-bold">({{ $listings->total() }})</span> kulingana na mahitaji yako.</p>
            </div>
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Nyumbani</a></li>
                    <li class="breadcrumb-item active">Search</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-sliders2 me-2 text-primary"></i> Chuja Matokeo
                    </h6>
                    <hr class="opacity-10">
                    
                    <form action="{{ route('listings.search') }}" method="GET">
                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">TAFUTA NENO</label>
                            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control form-control-sm rounded-pill px-3" placeholder="Mfano: Gari, Nyumba...">
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">MKOA</label>
                            <select name="region" class="form-select form-select-sm rounded-pill">
                                <option value="">Mikoa yote...</option>
                                @foreach($regions as $reg)
                                    <option value="{{ $reg->id }}" {{ request('region') == $reg->id ? 'selected' : '' }}>
                                        {{ $reg->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold text-muted mb-2">AINA YA BIDHAA</label>
                            @foreach($categories as $cat)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" value="{{ $cat->id }}" id="cat{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }}>
                                <label class="form-check-label small" for="cat{{ $cat->id }}">
                                    {{ $cat->name }}
                                </label>
                            </div>
                            @endforeach
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" value="" id="catAll" {{ request('category') == '' ? 'checked' : '' }}>
                                <label class="form-check-label small" for="catAll">Zote</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                            <i class="bi bi-filter me-1"></i> UPDATE RESULTS
                        </button>
                        
                        @if(request()->anyFilled(['keyword', 'region', 'category']))
                            <a href="{{ route('listings.search') }}" class="btn btn-link btn-sm w-100 mt-2 text-decoration-none text-danger small">Futa Filters Zote</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($listings as $listing)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 listing-card border-bottom border-primary border-3 transition-hover">
                        <div class="position-relative">
                            <img src="{{ asset($listing->thumbnail) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 m-2">
                                <span class="badge bg-dark rounded-pill opacity-75">Tsh {{ number_format($listing->price) }}</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-primary fw-bold text-uppercase" style="font-size: 0.7rem;">{{ $listing->category->name }}</small>
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $listing->region->name }}</small>
                            </div>
                            <h6 class="fw-bold mb-3 text-dark">{{ Str::limit($listing->title, 40) }}</h6>
                            <a href="{{ route('listings.show', $listing->slug) }}" class="btn btn-primary btn-sm w-100 rounded-pill">Angalia Undani</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" width="120" class="opacity-25 mb-3">
                    <h5 class="fw-bold text-muted">Hatukufanikiwa Kupata!</h5>
                    <p class="text-muted small">Jaribu kubadilisha mkoa au aina ya bidhaa unayotafuta.</p>
                    <a href="{{ route('listings.search') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Onyesha Bidhaa Zote</a>
                </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $listings->appends(request()->input())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.3s ease; }
    .transition-hover:hover { transform: translateY(-8px); }
    .sticky-top { z-index: 10; }
</style>
@endsection