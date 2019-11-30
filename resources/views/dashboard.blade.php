@extends('layouts.page')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/dashboard.css') }}">
    <link rel="stylesheet" href="/css/icomoon/style.css">
@endsection

@section('page')
    <div id="app">
        <dashboard></dashboard>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/dashboard.js') }}"></script>
@endsection