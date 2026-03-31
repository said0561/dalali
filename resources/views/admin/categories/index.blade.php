@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <div>
            <h4 class="fw-bold mb-0">Usimamizi wa Makundi</h4>
            <p class="text-muted small mb-0">Ongeza, hariri au futa aina za bidhaa kwenye mfumo.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addCategory">
            <i class="bi bi-plus-lg me-1"></i> Ongeza Kundi
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Icon</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Jina la Kundi</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Idadi ya Bidhaa</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td class="ps-4">
                                <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi {{ $cat->icon ?? 'bi-tag' }} fs-5"></i>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">{{ $cat->name }}</span>
                                <div class="text-muted small">slug: {{ $cat->slug }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 rounded-pill">
                                    {{ $cat->listings_count ?? $cat->listings->count() }} Bidhaa
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                    <button class="btn btn-white btn-sm px-3 border-end" data-bs-toggle="modal" data-bs-target="#edit{{ $cat->id }}">
                                        <i class="bi bi-pencil-square text-primary me-1"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-white btn-sm px-3" onclick="return confirm('Je, una uhakika unataka kufuta kundi hili?')">
                                            <i class="bi bi-trash text-danger me-1"></i> Futa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-folder2-open display-4 d-block mb-2 opacity-25"></i>
                                Hakuna kundi lililopatikana.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold" id="addCategoryLabel">Ongeza Kundi Jipya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">JINA LA KUNDI</label>
                        <input type="text" name="name" class="form-control rounded-pill px-3 shadow-sm" placeholder="Mfano: Viwanja & Mashamba" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">BOOTSTRAP ICON (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="bi bi-search"></i></span>
                            <input type="text" name="icon" class="form-control border-start-0 rounded-end-pill shadow-sm" placeholder="Mfano: bi-house-door">
                        </div>
                        <div class="form-text small mt-2">Tumia majina ya icons kutoka <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Funga</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Hifadhi Sasa</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($categories as $cat)
<div class="modal fade" id="edit{{ $cat->id }}" tabindex="-1" aria-labelledby="editLabel{{ $cat->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold" id="editLabel{{ $cat->id }}">Hariri Kundi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jina la Kundi</label>
                        <input type="text" name="name" value="{{ $cat->name }}" class="form-control rounded-pill px-3 shadow-sm" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Bootstrap Icon</label>
                        <input type="text" name="icon" value="{{ $cat->icon }}" class="form-control rounded-pill px-3 shadow-sm">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Funga</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Hifadhi Mabadiliko</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .btn-group .btn {
        border-color: #eee;
    }
    .btn-group .btn:hover {
        background-color: #f8f9fa;
    }
    .bg-primary-subtle {
        background-color: #e7f1ff;
    }
</style>
@endsection