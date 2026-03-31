@extends('layouts.app')
@section('content')
<div class="container text-center py-5">
    <div class="card shadow border-0 p-5">
        <h2 class="text-warning fw-bold">Akaunti Yako Inahakikiwa!</h2>
        <p class="lead">Habari {{ auth()->user()->name }}, asante kwa kujisajili. Admin anapitia taarifa zako, utaruhusiwa kutumia mfumo hivi punde.</p>
        <div class="mt-4">
             <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary-custom text-white">Ondoka Kwanza</a>
        </div>
    </div>
</div>
@endsection