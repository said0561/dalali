{{-- 1. DASHBOARD LOGIC --}}
<li class="nav-item">
    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}">
            <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard Admin
        </a>
    @else
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard Yangu
        </a>
    @endif
</li>

{{-- 2. USIMAMIZI MKUU (SUPER ADMIN ONLY - ROLE 1) --}}
@if(auth()->user()->role_id == 1)
    <p class="text-muted small fw-bold mt-4 mb-2 opacity-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
        Usimamizi Mkuu
    </p>

    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') ? 'active fw-bold' : '' }}">
            <i class="bi bi-person-gear me-2"></i> Watumiaji wa Mfumo
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active fw-bold' : '' }}">
            <i class="bi bi-tags-fill me-2"></i> Makundi (Categories)
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.index') ? 'active fw-bold' : '' }}">
            <i class="bi bi-shield-lock me-2"></i> User Roles
        </a>
    </li>
@endif

{{-- 3. USIMAMIZI WA MADALALI & BIDHAA (SUPER ADMIN NA REGIONAL ADMIN) --}}
@if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
    <p class="text-muted small fw-bold mt-4 mb-2 opacity-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
        Usimamizi wa {{ auth()->user()->role_id == 2 ? 'Mkoa' : 'Mfumo' }}
    </p>

    {{-- Maombi ya Madalali --}}
    <li class="nav-item">
        <a href="{{ route('admin.brokers.pending') }}" class="nav-link {{ request()->routeIs('admin.brokers.pending') ? 'active fw-bold' : '' }}">
            <i class="bi bi-person-check me-2"></i> Maombi ya Madalali
            
            @php
                $user = auth()->user();
                $pendingBrokers = \App\Models\User::where('is_approved', 0)
                                ->where('role_id', 3)
                                ->when($user->role_id == 2, function($q) use($user) {
                                    return $q->where('region_id', $user->region_id);
                                })
                                ->count();
            @endphp

            @if($pendingBrokers > 0)
                <span class="badge bg-danger rounded-pill float-end">{{ $pendingBrokers }}</span>
            @endif
        </a>
    </li>

    {{-- Uhakiki wa Bidhaa (Listings) --}}
    <li class="nav-item">
        <a href="{{ route('admin.listings.pending') }}" class="nav-link {{ request()->routeIs('admin.listings.pending') ? 'active fw-bold' : '' }}">
            <i class="bi bi-clock-history me-2"></i> Uhakiki wa Bidhaa
            
            @php
                $pendingListings = \App\Models\Listing::where('status', 'pending')
                                ->when($user->role_id == 2, function($q) use($user) {
                                    return $q->whereHas('user', function($u) use($user) {
                                        $u->where('region_id', $user->region_id);
                                    });
                                })
                                ->count();
            @endphp

            @if($pendingListings > 0)
                <span class="badge bg-warning text-dark rounded-pill float-end">{{ $pendingListings }}</span>
            @endif
        </a>
    </li>
@endif

{{-- 4. BIDHAA ZANGU (DALALI ONLY - ROLE 3) --}}
@if(auth()->user()->role_id == 3)
    <p class="text-muted small fw-bold mt-4 mb-2 opacity-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
        Bidhaa Zangu
    </p>

    <li class="nav-item">
        <a href="{{ route('listings.create') }}" class="nav-link {{ request()->routeIs('listings.create') ? 'active fw-bold' : '' }}">
            <i class="bi bi-plus-circle-fill me-2"></i> Ongeza Bidhaa
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('listings.index') }}" class="nav-link {{ request()->routeIs('listings.index') ? 'active fw-bold' : '' }}">
            <i class="bi bi-house-door me-2"></i> Bidhaa Zilizopostiwa
        </a>
    </li>
@endif

{{-- 5. AKAUNTI --}}
<p class="text-muted small fw-bold mt-4 mb-2 opacity-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
    Akaunti
</p>
<li class="nav-item">
    <a href="#" class="nav-link {{ request()->is('profile*') ? 'active fw-bold' : 'opacity-75' }}">
        <i class="bi bi-person-circle me-2"></i> Profile Yangu
    </a>
</li>