@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h4 class="fw-bold mb-0 text-primary">Bidhaa Zinazosubiri Uhakiki</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Picha & Kichwa</th>
                            <th>Dalali</th>
                            <th>Mkoa</th>
                            <th>Bei</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $listing)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $listing->thumbnail) }}" class="rounded-3 me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold">{{ $listing->title }}</div>
                                        <small class="text-muted">{{ $listing->category->name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $listing->user->name }}</td>
                            <td>{{ $listing->user->region->name }}</td>
                            <td class="fw-bold text-primary">Tsh {{ number_format($listing->price) }}</td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    {{-- Kitufe cha Kuona Bidhaa --}}
                                    <a href="{{ route('listings.show', $listing->slug) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">View</a>

                                    {{-- Kitufe cha Approve --}}
                                    <form action="{{ route('admin.listings.approve', $listing->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Thibitisha</button>
                                    </form>

                                    {{-- Kitufe cha Kukataa --}}
                                    <form action="{{ route('admin.listings.reject', $listing->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Kataa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Hakuna bidhaa mpya kwa sasa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection