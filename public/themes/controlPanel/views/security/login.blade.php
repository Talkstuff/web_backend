@extends('controlPanel::layouts.master')

@section('app')
    <login></login>
@endsection

@section('styles')
    <link rel="stylesheet" href="/build/app.min.css">
@endsection
@section('scripts')
    <script src="/themes/controlPanel/views/security/login.min.js"></script>
@endsection