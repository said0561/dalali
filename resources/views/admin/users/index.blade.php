@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Sehemu ya Juu: Kichwa na Kitufe cha Kuongeza --}}
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h4 class="fw-bold mb-0 text-primary">Usimamizi wa Watumiaji</h4>
        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill me-2"></i> Sajili Mtumiaji
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Jina & Simu</th>
                            <th class="py-3">Cheo</th>
                            <th class="py-3">Mkoa</th>
                            <th class="py-3">Malipo (Days)</th>
                            <th class="py-3 text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->phone }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $user->role_id == 1 ? 'bg-danger' : ($user->role_id == 2 ? 'bg-info text-dark' : 'bg-primary') }} rounded-pill px-3">
                                    {{ $user->role->display_name ?? $user->role->name }}
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-geo-alt me-1 text-secondary"></i>
                                {{ $user->region->name ?? '—' }}
                            </td>
                            <td>
                                @if($user->role_id == 3)
                                    @if($user->subscription_until && $user->subscription_until->isFuture())
                                        <span class="text-success small fw-bold">
                                            <i class="bi bi-check-circle-fill me-1"></i> Active: {{ $user->subscription_until->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-danger small fw-bold">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Imeisha/NULL
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    {{-- Kitufe cha Malipo --}}
                                    @if($user->role_id == 3)
                                    <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="return confirm('Umeshapokea Tsh 2,000 kutoka kwa huyu Dalali?')">
                                            Lipa 2k
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Toggle Status --}}
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $user->is_approved ? 'btn-success' : 'btn-warning text-white' }} rounded-pill px-3">
                                            {{ $user->is_approved ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>

                                    {{-- Edit Button --}}
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editUser{{ $user->id }}">
                                        Edit
                                    </button>

                                    {{-- Delete Button --}}
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Je, una uhakika unataka kumfuta mtumiaji huyu?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODALS (Add & Edit) ZINABAKI HAPA CHINI --}}

{{-- Modal ya Kusajili --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold text-primary">Sajili Mtumiaji Mpya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-secondary">JINA KAMILI</label>
                        <input type="text" name="name" class="form-control rounded-pill px-3 shadow-sm border-light" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-secondary">NAMBA YA SIMU</label>
                        <input type="text" name="phone" class="form-control rounded-pill px-3 shadow-sm border-light" placeholder="07XXXXXXXX" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small fw-bold mb-2 text-secondary">CHEO (ROLE)</label>
                            <select name="role_id" class="form-select rounded-pill shadow-sm border-light" required>
                                <option value="" disabled selected>Chagua Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold mb-2 text-secondary">MKOA</label>
                            <select name="region_id" class="form-select rounded-pill shadow-sm border-light">
                                <option value="" disabled selected>Chagua Mkoa</option>
                                @foreach($regions as $reg)
                                    <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mt-4 pt-3 border-top">
                        <label class="small fw-bold mb-2 text-secondary text-uppercase">Set Security Password</label>
                        <input type="password" name="password" class="form-control rounded-pill px-3 mb-2 shadow-sm border-light" placeholder="Password" required>
                        <input type="password" name="password_confirmation" class="form-control rounded-pill px-3 shadow-sm border-light" placeholder="Rudia Password" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow">HIFADHI MTUMIAJI</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal za Edit --}}
@foreach($users as $user)
<div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Hariri Taarifa & Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-secondary">JINA KAMILI</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control rounded-pill px-3 shadow-sm border-light" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-secondary">NAMBA YA SIMU</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control rounded-pill px-3 shadow-sm border-light" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small fw-bold mb-2 text-secondary">CHEO</label>
                            <select name="role_id" class="form-select rounded-pill shadow-sm border-light">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold mb-2 text-secondary">MKOA</label>
                            <select name="region_id" class="form-select rounded-pill shadow-sm border-light">
                                @foreach($regions as $reg)
                                    <option value="{{ $reg->id }}" {{ $user->region_id == $reg->id ? 'selected' : '' }}>{{ $reg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mt-4 pt-3 border-top">
                        <label class="small fw-bold mb-2 text-secondary">RESET PASSWORD (Optional)</label>
                        <input type="password" name="password" class="form-control rounded-pill px-3 mb-2 shadow-sm border-light" placeholder="Password Mpya">
                        <input type="password" name="password_confirmation" class="form-control rounded-pill px-3 shadow-sm border-light" placeholder="Rudia Password">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow">HIFADHI MABADILIKO</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection