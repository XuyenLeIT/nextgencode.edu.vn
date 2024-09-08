@extends('layouts.client')
<link rel="stylesheet" href="{{ asset('css/client/home.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css" rel="stylesheet" />
@section('title', 'Home Page')
<meta property="og:title" content="Học lập trình mọi lúc, chinh phục tương lai!">
<meta property="og:description"
    content="cung cấp khóa học từ cơ bản đến nâng cao, giúp bạn nhanh chóng nắm vững các ngôn ngữ như ,Net, Java, và JavaScript... Học tập linh hoạt với nội dung súc tích và bài tập thực hành thực tế.">
<meta property="og:image" content="https://png.pngtree.com/png-clipart/20200701/original/pngtree-children-s-software-programming-png-image_5401259.jpg">
<meta property="og:url" content="https://www.nextgencode.edu.vn/">
<meta property="og:type" content="website">
@section('content')
    <div class="container-fluid">
        <div class="row gx-3 mt-2 lazy-content">
            <div class="{{ $banner ? ($banner->status ? 'col-md-9' : 'col-md-12') : 'col-md-12' }} mt-5">
                <h4 class="fw-bold">Khóa Học Lập Trình</h4>
                <div class="row gx-2 gy-2">
                    @foreach ($courses as $item)
                        @php
                            $slug = Str::slug($item->name);
                        @endphp
                        <div
                            class="{{ $banner ? ($banner->status ? 'col-md-4' : 'col-md-3') : 'col-md-3' }} col-sm-6 col-12">
                            <div class="course__item">
                                <img class="course_image" src="{{ $item->thumbnail }}" />
                                <p class="course__name fw-bold">{{ $item->name }}</p>
                                <p class="course__start-title">Ngay Khai giang</p>
                                <p class="course__start-date">{{ $item->status ? $item->startDate : 'đang cập nhật...' }}
                                </p>
                                <div class="course__start__typeLearn text-start mb-2">
                                    <span class="badge bg-success">{{ $item->typeLearn ? 'Online' : 'Offline' }}</span>
                                </div>
                                @if ($item->status)
                                    <a class="btn__view-course" href="{{ route('client.course', [$slug, $item->id]) }}">Xem
                                        Khoa
                                        hoc</a>
                                @else
                                    <a class="btn__view-course-disable">Xem Khoa hoc</a>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($banner->status)
                @php
                    $slug = Str::slug($banner->title);
                @endphp
                <div class="col-md-3 col-sm-12 col-12">
                    <div class="banner"
                        style="background-image: url({{ $banner->image }});background-repeat: no-repeat; background-position: center center; background-size: cover;">
                        <div class="banner-background"></div>
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $banner->title }}</h3>
                            <p class="banner-content">{{ $banner->sortContent }}</p>
                            <div class="banner-info">
                                <p class="banner-date"><strong>Ngày khai giảng:</strong> {{ $banner->startDate }}</p>
                                <p class="banner-promotion"><strong>Ưu đãi: </strong>{{ $banner->promotion }}</p>
                            </div>
                            <a href="{{ route('client.course', [$slug, $banner->id]) }}" class="cta-button">Xem ngay!</a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="row lazy-content">
            <div class="container mt-4">
                <h4 class="text-center fw-bold">Kiến Thức Lập Trình</h4>
                <div class="row gx-2">
                    <div class="carousel-know" data-flickity='{"pageDots": false }'>
                        @foreach ($knows as $item)
                            @php
                                $slug = Str::slug($item->title);
                            @endphp
                            <div class="col-md-3 col-sm-6 col-12 carousel-know-cell">
                                <a class="know__item-link"
                                    href="{{ route('client.knowledge.detail', [$slug, $item->id]) }}">
                                    <div class="know-item">
                                        <img class="know-image" src="{{ $item->thumbnail }}" />
                                        <p class="know-title">{{ $item->title }}</p>
                                        <p class="know-date">2024-10-10</p>
                                        <p class="know-des">{{ $item->sort_content }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="course-route">
                <h4 class="text-center">Lộ Trình học backend</h4>
                <div class="timeline">
                    @foreach ($timelines as $key => $item)
                        <div class="container-timeline {{ $key % 2 == 0 ? 'left' : 'right' }}">
                            <div class="icon">
                                @if ($key < 10)
                                    <span>0{{ $key }}</span>
                                @else
                                    <span>{{ $key }}</span>
                                @endif
                            </div>
                            <div class="content">
                                <h2>{{ $item->title }}</h2>
                                <p>{{ $item->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

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
