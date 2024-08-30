@extends('layouts.client')
<link rel="stylesheet" href="{{ asset('css/client/knowledge.css') }}">
@section('title', 'Home Page')

@section('content')
    <div class="container knowledge">
        <h4 class="text-center">Blog Kien Thuc</h4>
        <div class="row gx-3">
            <div class="col-md-8">
                @foreach ($knows as $item)
                    <a class="know__item-link" href="{{ route('client.knowledge.detail', $item->id) }}">
                        <div class="know-item lazy-content">
                            <div class="know-item-info">
                                <p class="know-title">{{ $item->title }}</p>
                                <p class="know-des">{{ $item->sort_content }}</p>
                                <p class="know-date">2024-10-10</p>
                            </div>
                            <img class="know-image" src="/{{ $item->thumbnail }}" />
                        </div>
                    </a>
                @endforeach
            </div>
            @if ($banner->status)
                <div class="col-md-4 col-12">
                    <div class="banner"
                        style="background-image: url({{ $banner->image }});background-repeat: no-repeat; background-position: center center; background-size: cover;">
                        <div class="banner-background"></div>
                        <div class="banner-content">
                            <h4 class="banner-title">{{ $banner->title }}</h4>
                            <p class="banner-content">{{ $banner->sortContent }}</p>
                            <div class="banner-info">
                                <p class="banner-date"><strong>Ngày khai giảng:</strong> {{ $banner->startDate }}</p>
                                <p class="banner-promotion"><strong>Ưu đãi:</strong>{{ $banner->promotion }}</p>
                            </div>
                            <a href="{{ route('client.course', $banner->id) }}" class="cta-button" >Xem ngay!</a>
                        </div>
                    </div>
                </div>
            @endif
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
