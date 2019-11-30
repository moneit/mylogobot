@extends('layouts.html')

@section('title')
    <title>{{ config('app.name', 'Title') }}</title>
@endsection

@section('meta-description')
    <meta name="description" content="" />
@endsection

@section('body')
    <!-- todo: replace 'page' with 'sections' - https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/Using_HTML_sections_and_outlines#Sectioning_roots -->
    @yield('page')

    <script src="https://js.stripe.com/v3/"></script>
    @yield('scripts')
@endsection