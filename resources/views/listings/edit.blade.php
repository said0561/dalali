@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-primary">Hariri Tangazo</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('listings.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">KICHWA CHA TANGAZO</label>
                            <input type="text" name="title" value="{{ old('title', $listing->title) }}" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">KUNDI</label>
                                <select name="category_id" class="form-select">
                                    @foreach(App\Models\Category::all() as $cat)
                                        <option value="{{ $cat->id }}" {{ $listing->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">BEI (TSH)</label>
                                <input type="number" name="price" value="{{ old('price', $listing->price) }}" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">MAELEZO</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $listing->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">BADILISHA PICHA KUU (ACHA WAZI KAMA HUBADILISHI)</label>
                            <input type="file" name="thumbnail" class="form-control">
                            <div class="mt-2 text-muted small italic">Picha ya sasa: {{ basename($listing->thumbnail) }}</div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow fw-bold">
                            HIFADHI MABADILIKO
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection