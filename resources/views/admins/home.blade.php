@extends('layouts.admin')

@section('title', 'Home Page')

@section('content')
    <div class="text-center">
        <h1>Welcome to the Admin Page</h1>
        <img src="{{ asset('logo/admin.webp') }}" alt="Admin Image">
    </div>
@endsection
