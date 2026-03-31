@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Admin Control Panel</h3>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3">
                <small class="text-uppercase opacity-75">Jumla ya Watumiaji</small>
                <h2 class="fw-bold mb-0">{{ $stats['total_users'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark p-3">
                <small class="text-uppercase opacity-75">Madalali Wapya (Pending)</small>
                <h2 class="fw-bold mb-0">{{ $stats['pending_users'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white p-3">
                <small class="text-uppercase opacity-75">Bidhaa Hewani</small>
                <h2 class="fw-bold mb-0">{{ $stats['active_listings'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-3">
                <small class="text-uppercase opacity-75">Jumla ya Bidhaa</small>
                <h2 class="fw-bold mb-0">{{ $stats['total_listings'] }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-primary">Madalali Wapya (Wanahitaji Uhakiki)</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Jina</th>
                                <th>Simu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Approve</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Hakuna dalali mpya.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-success">Bidhaa Mpya (Zinazosubiri)</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Bidhaa</th>
                                <th>Dalali</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingListings as $list)
                            <tr>
                                <td>{{ Str::limit($list->title, 20) }}</td>
                                <td>{{ $list->user->name }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('listings.show', $list->slug) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-circle"><i class="bi bi-eye"></i></a>
                                        <button class="btn btn-sm btn-success rounded-pill px-3">Publish</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Hakuna bidhaa mpya.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection