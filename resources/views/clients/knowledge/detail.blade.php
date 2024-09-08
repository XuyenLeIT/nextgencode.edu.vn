@extends('layouts.client')
<link rel="stylesheet" href="{{ asset('css/client/knowledge.css') }}">
@section('title', 'Home Page')
<meta name="description" content="{{ $pageDescription }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:image" content="https://www.nextgencode.edu.vn/knowledgesImages/66dd6e2cee3d1.jpg">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:type" content="website">
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
