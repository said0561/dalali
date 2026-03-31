@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Maombi ya Madalali</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Madalali Wapya</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tarehe</th>
                            <th>Jina Kamili</th>
                            <th>Namba ya Simu</th>
                            <th>Mkoa</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brokers as $user)
                        <tr>
                            <td class="ps-4 small text-muted">{{ $user->created_at->format('d M, Y') }}</td>
                            <td class="fw-bold">{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->region->name ?? 'N/A' }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" onclick="return confirm('Unataka kumkubali dalali huyu?')">
                                        <i class="bi bi-check-lg me-1"></i> Approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                                Hakuna maombi mapya ya madalali kwa sasa.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $brokers->links() }}
    </div>
</div>
@endsection