@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Manager')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Manager')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Tampilan @auth
                    {{ Auth::user()->level_id == 1 ? 'Admin' : 'Manager' }}
                @endauth
            </div>
            <div class="card-body">
                <h1>Login Sebagai:
                    @auth
                        {{ Auth::user()->level_id == 1 ? 'Admin' : 'Manager' }}
                    @endauth
                </h1>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush