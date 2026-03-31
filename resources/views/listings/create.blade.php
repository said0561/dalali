@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-primary">Pandisha Bidhaa/Huduma Mpya</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">KICHWA CHA TANGAZO</label>
                            <input type="text" name="title" value="{{ old('title') }}" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Mfano: Gari Toyota IST inapangishwa kwa mwezi">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">KUNDI (CATEGORY)</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Chagua Kundi --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">BEI (TSH)</label>
                                <input type="number" name="price" value="{{ old('price') }}" 
                                       class="form-control @error('price') is-invalid @enderror" placeholder="0.00">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-primary">PICHA KUU (COVER)</label>
                                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror">
                                @error('thumbnail') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-secondary">PICHA ZA NDANI (GALLERY)</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">MAELEZO YA BIDHAA</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow fw-bold">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> PANDISHA TANGAZO
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection