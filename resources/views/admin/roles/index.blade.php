@extends('layouts.app') 

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        {{-- Maneno ya Blue kama ulivyoelekeza --}}
        <h3 class="text-primary fw-bold">Usimamizi wa Vyeo (User Roles)</h3>
        
        {{-- Kitufe cha Add Role --}}
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
            <i class="bi bi-plus-lg me-1"></i> Ongeza Cheo
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </div>
    @endif

    <div class="card bg-dark border-secondary shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="bg-secondary text-uppercase small text-white border-bottom border-secondary">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Jina la Cheo</th>
                            <th class="py-3 px-4">Tarehe ya Kuundwa</th>
                            <th class="py-3 px-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td class="px-4 text-secondary">{{ $role->id }}</td>
                            <td class="px-4 fw-bold text-info">{{ $role->name }}</td>
                            <td class="px-4 text-secondary">
                                {{ $role->created_at ? $role->created_at->format('d M, Y') : 'Haikupatikana' }}
                            </td>
                            <td class="px-4 text-end">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editRole{{ $role->id }}">
                                    <i class="bi bi-pencil-square"></i> Hariri
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="background-color: #ffffff;">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Sajili Cheo Kipya</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-dark p-4">
                    <div class="form-group">
                        <label class="fw-bold mb-2">Jina la Cheo</label>
                        <input type="text" name="name" class="form-control" placeholder="Mfano: Mhasibu" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                    <button type="submit" class="btn btn-success px-4">Hifadhi Cheo</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($roles as $role)
<div class="modal fade" id="editRole{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg" style="background-color: #ffffff;">
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title">Hariri Cheo: {{ $role->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-dark p-4">
                    <div class="form-group">
                        <label class="fw-bold mb-2">Jina la Cheo</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Funga</button>
                    <button type="submit" class="btn btn-primary px-4">Hifadhi Mabadiliko</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .modal { background: rgba(0, 0, 0, 0.75); }
    .table-dark { background-color: transparent !important; }
    .card { border-radius: 10px; overflow: hidden; }
</style>
@endsection