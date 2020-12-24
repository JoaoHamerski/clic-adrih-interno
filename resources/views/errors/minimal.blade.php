@extends('layouts.app')

@push('css')
    <style>
        .border-right-3 {
            border-right: 3px solid #ed1e79;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex align-items-center min-vh-100">
        <div class="d-flex flex-row mx-auto">
            <h1 class="text-center font-weight-bold text-pink mb-4 border-right-3 pr-3 mr-3">
                @yield('code')
            </h1>

            <div>
            <h5 class="text-center text-secondary text-uppercase font-weight-bold">
                @yield('message')
            </h5>
            <small><a href="{{ route('home') }}">Voltar para página inicial</a></small>
            </div>
        </div>
    </div>
@endsection