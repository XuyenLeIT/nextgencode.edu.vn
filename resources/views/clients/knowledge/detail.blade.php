@extends('layouts.client')
<link rel="stylesheet" href="{{ asset('css/client/knowledge.css') }}">
@section('title', 'Home Page')

@section('content')
    <div class="container">
        <div class="knowledge">
            <h4 class="text-center fw-bold">{{ $know->title }}</h4>
            <img class="image-top" src="{{ $know->thumbnail }}" />
            <p>{!! $know->description !!}</p>
        </div>
    </div>
    <script type="text/javascript">
        setTimeout(function() {
            // Closing the alert 
            $('.alert').alert('close');
            console.log("alo 123");
        }, 2000);
    </script>
@endsection
