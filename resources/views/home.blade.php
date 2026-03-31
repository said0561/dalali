@extends('layouts.app')

@section('content')
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(auth()->user()->role->name === 'broker')
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <h5>Hali ya Akaunti</h5>
                        @if(auth()->user()->hasActiveSubscription())
                            <span class="badge bg-success">Imelipiwa (Active)</span>
                            <p class="mt-2 text-muted">Inaisha tarehe: {{ auth()->user()->subscription_until->format('d M, Y') }}</p>
                        @else
                            <span class="badge bg-danger">Hajalipia (Expired)</span>
                            <p class="mt-2">Tafadhali lipia <strong>Tsh 2,000</strong> sasa uendelee kupost.</p>
                            <a href="#" class="btn btn-primary btn-sm">Lipia Sasa</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
