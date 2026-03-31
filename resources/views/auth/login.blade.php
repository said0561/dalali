@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Dalali Mkuu Logo" style="width: 100px;">
                        <h3 class="fw-bold mt-3" style="color: #0056b3;">Dalali Mkuu</h3>
                        <p class="text-muted">Ingia kwenye akaunti yako</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Namba ya Simu</label>
                            <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                   placeholder="2557XXXXXXXX" value="{{ old('phone') }}" required autofocus>
                            @error('phone')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Neno la Siri (Password)</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm border-0" style="background-color: #0056b3;">
                                Ingia Sasa
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">Hauna akaunti? <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #0056b3;">Jisajili Hapa</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection