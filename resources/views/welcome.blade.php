@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle'. 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
    <p>Welcome to Pubg Mobile</p>
@stop


{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts--}}

@push('js')
    <script>console.log("HI, I'm using the Laralvel.AdminLTE package!");</script>
@endpush
