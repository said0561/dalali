@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh; margin-top: 30px; margin-bottom: 30px;">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Dalali Mkuu Logo" style="width: 80px;">
                        <h3 class="fw-bold mt-2" style="color: #0056b3;">Dalali Mkuu</h3>
                        <p class="text-muted">Jisajili kama Dalali kuanza kazi</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Jina Kamili</label>
                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Ingiza jina lako">
                                @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Namba ya Simu (255...)</label>
                                <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="Mfano: 255743434305">
                                @error('phone') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Mkoa Unaofanyia Kazi</label>
                                <select name="region_id" class="form-select form-select-lg @error('region_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Chagua Mkoa...</option>
                                    @foreach(\App\Models\Region::all() as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                                @error('region_id') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Neno la Siri</label>
                                <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                                @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Rudia Neno la Siri</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm border-0 py-3" style="background-color: #0056b3; font-weight: 600;">
                                Kamilisha Usajili
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">Tayari una akaunti? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #0056b3;">Ingia Hapa</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection